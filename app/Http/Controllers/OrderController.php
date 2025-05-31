<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
 use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ClientOrderMail;
use App\Mail\AdminOrderMail;  
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentTransaction;

class OrderController extends Controller
{
    

    public function processOrder(Request $request)
    {
        // Étape 1 : Validation initiale
        $initialValidator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required|regex:/^\+?[0-9]{8,15}$/',
            'gouvernorat' => 'required|string',
            'adress' => 'required|string',
            'products' => 'required|string|json',
            'mode_paiement' => 'required|in:espece,carte',
            'sex' => 'nullable|in:male,female,other',
            'date_naissance' => 'nullable|date|before_or_equal:today',
        ]);
     
        if ($initialValidator->fails()) {
            return back()->withErrors($initialValidator)->withInput();
        }
     
        // Étape 2 : Décodage des produits
        $productsArray = json_decode($request->input('products'), true);
        if (json_last_error() !== JSON_ERROR_NONE || empty($productsArray)) {
            return back()->withErrors(['products' => 'Données du panier invalides ou vides.'])->withInput();
        }
     
        // Étape 3 : Validation des produits
        $productsValidator = Validator::make(['products' => $productsArray], [
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);
     
        if ($productsValidator->fails()) {
            return back()->withErrors($productsValidator)->withInput();
        }
     
        DB::beginTransaction();
     
        try {
            $redOrder = 'ORD-' . strtoupper(uniqid());
            $sourceCommande = $request->input('source_commande', 'web');
            $ipClient = $request->ip();
            $deviceClient = $this->detectDevice($request);
            $orders = [];
            $totalAmount = 0;
     
            foreach ($productsArray as $item) {
                $produit = Product::where('id', $item['product_id'])->lockForUpdate()->first();
     
                if (!$produit || $produit->quantity < $item['quantity']) {
                    DB::rollBack();
                    return back()->with('error', 'Produit indisponible ou stock insuffisant.')->withInput();
                }
     
                $produit->decrement('quantity', $item['quantity']);
     
                $order = Order::create([
                    'red_order' => $redOrder,
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'email' => $request->email,
                    'telephone' => $request->telephone,
                    'gouvernorat' => $request->gouvernorat,
                    'adress' => $request->adress,
                    'sex' => $request->sex,
                    'date_naissance' => $request->date_naissance,
                    'date_order' => now(),
                    'id_produit' => $item['product_id'],
                    'prix_produit' => $item['price'],
                    'quantite_produit' => $item['quantity'],
                    'mode_paiement' => $request->mode_paiement,
                    'source_commande' => $sourceCommande,
                    'ip_client' => $ipClient,
                    'device_client' => $deviceClient,
                    'status' => 'encours'
                ]);
     
                $totalAmount += $item['price'] * $item['quantity'];
                $orders[] = $order;
            }
     
            DB::commit();
     
            // Envoi des emails
            try {
                Mail::to($request->email)->send(new ClientOrderMail($orders));
                $adminUsers = User::whereNotNull('email')->get();
                foreach ($adminUsers as $user) {
                    Mail::to($user->email)->send(new AdminOrderMail($orders));
                }
            } catch (\Exception $mailException) {
                Log::error("Erreur lors de l'envoi de l'email : " . $mailException->getMessage());
            }
 
    if ($request->mode_paiement === 'carte') {
        $apiKey = env('KONNECT_API_KEY');
        $walletId = env('KONNECT_WALLET_ID');
        $amount = intval($totalAmount * 1000)+(8000+1000); // total en millimes
        $orderId = 'ORDER-' . time();
 
        Log::info('Paiement carte - Données préparées', [
            'apiKey' => $apiKey,
            'walletId' => $walletId,
            'amount' => $amount,
            'orderId' => $orderId,
            'email' => $request->email,
        ]);
 
        $data = [
            'receiverWalletId' => $walletId,
            'amount' => $amount,
            'orderId' => $orderId,
            'successUrl' => route('payment.success', ['redOrder' => $redOrder]),
            'failUrl' => route('payment.fail', ['redOrder' => $redOrder]),
            'email' => $request->email,
        ];
 
        try {
            $client = new Client();
            $response = $client->post('https://api.konnect.network/api/v2/payments/init-payment', [
                'json' => $data,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-api-key' => $apiKey,
                ]
            ]);
 
            $result = json_decode($response->getBody()->getContents(), true);
 
            Log::info('Réponse de Konnect', ['result' => $result]);
 
            // Gestion du statut selon la réponse Konnect (3 états)
            $status = 'failed';
            $payUrl = $result['payUrl'] ?? null;
 
            // Si la réponse contient explicitement un statut
            if (isset($result['status'])) {
                if ($result['status'] === 'pending') {
                    $status = 'pending';
                } elseif (in_array($result['status'], ['success', 'succeeded', 'paid'])) {
                    $status = 'success';
                } elseif (in_array($result['status'], ['fail', 'failed', 'cancelled', 'canceled'])) {
                    $status = 'failed';
                }
            } elseif (!empty($payUrl)) {
                // Si pas de statut mais payUrl présent, on considère pending
                $status = 'pending';
            }
 
            // Vérifier si le payUrl contient "fail" ou "cancel" pour marquer comme failed
            if (!empty($payUrl) && (stripos($payUrl, 'fail') !== false || stripos($payUrl, 'cancel') !== false)) {
                $status = 'failed';
            }
 
            // Toujours enregistrer la transaction avec status 'attente' (ou 'pending')
            PaymentTransaction::create([
                'red_order' => $redOrder,
                'order_id' => $orderId,
                'amount' => $amount / 1000,
                'status' => 'attente', // statut initial
                'payment_method' => 'card',
                'payment_url' => $payUrl,
                'payment_details' => $result
            ]);
 
            // Log du statut final
            Log::info('Statut de paiement enregistré', [
                'order_id' => $orderId,
                'red_order' => $redOrder,
                'status' => $status,
                'payUrl' => $payUrl,
                'result' => $result,
            ]);
 
            if ($status === 'pending' && $payUrl) {
                return redirect()->away($payUrl);
            }
 
            if ($status === 'success') {
                return redirect()->route('checkout.confirmation', ['redOrder' => $redOrder])
                    ->with('success', 'Paiement confirmé et commande validée.');
            }
 
            // Si échec
            return back()->with('error', 'Erreur lors de l\'initialisation du paiement.');
        } catch (\Exception $e) {
            Log::error('Exception Konnect', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
 
            // Enregistrer la transaction échouée
            PaymentTransaction::create([
                'red_order' => $redOrder,
                'order_id' => $orderId,
                'amount' => $amount / 1000,
                'status' => 'failed',
                'payment_method' => 'card',
                'payment_details' => [
                    'error' => $e->getMessage(),
                    'error_trace' => $e->getTraceAsString()
                ]
            ]);
 
            return back()->with('error', 'Erreur avec le service de paiement : ' . $e->getMessage());
        }
    }
     
     
            // Paiement par espèce ou autre
            return redirect()->route('checkout.confirmation', ['redOrder' => $redOrder])
                ->with('success', 'Commande confirmée. Email de confirmation envoyé.')
                ->with('clearCart', true);
     
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur commande: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Une erreur est survenue. Veuillez réessayer.')->withInput();
        }
    }
     
   /* private function detectDevice(Request $request)
    {
        $userAgent = $request->header('User-Agent');
        if (preg_match('/mobile/i', $userAgent)) return 'mobile';
        if (preg_match('/tablet/i', $userAgent)) return 'tablet';
        return 'desktop';
    }
     */



    public function checkout()
    {
        return view('checkout');
    }

    public function showOrderConfirmation($redOrder)
    {
        $orders = Order::with('product') // Eager load the product relationship
            ->where('red_order', $redOrder)
            ->get();

        if ($orders->isEmpty()) {
            Log::warning('Order not found for confirmation page', ['red_order' => $redOrder]);
            return redirect()->route('index')->with('error', 'Commande introuvable.'); // Redirect to a sensible page
        }

        // Calculate totals for display on confirmation page (optional but good practice)
        $subtotal = $orders->sum(function($order) {
            return $order->prix_produit * $order->quantite_produit;
        });
        $shipping = 8.00; // Assuming fixed shipping
        $tax = 1.00; // Assuming fixed tax
        $total = $subtotal + $shipping + $tax;

        return view('confirmation', compact('orders', 'subtotal', 'shipping', 'tax', 'total'));
    }

    protected function detectDevice(Request $request)
    {
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent()); // Ensure agent uses current request's user agent
        $agent->setHttpHeaders($request->headers->all()); // And headers

        if ($agent->isMobile()) return 'Mobile';
        if ($agent->isTablet()) return 'Tablet';
        if ($agent->isDesktop()) return 'Desktop'; // Explicitly check desktop
        return 'Unknown'; // Default case
    }
 //Afifcher orders
 public function index(Request $request)
{
    // Frais fixes
    $frais_livraison = 8;
    $frais_fiscal = 1;

    // Recherche par identifiant de commande
    $searchTerm = $request->input('search');

    // Récupérer les commandes avec leurs produits associés
    $ordersQuery = DB::table('orders')
        ->join('products', 'orders.id_produit', '=', 'products.id')
        ->leftJoin('payment_transactions', 'orders.red_order', '=', 'payment_transactions.red_order')
        ->select(
            'orders.id AS order_id',
            'orders.red_order',
            'orders.nom',
            'orders.prenom',
            'orders.telephone',
            'orders.email',
            'orders.date_order',
            'orders.status',
            'orders.adress',
            'orders.gouvernorat',
            'orders.quantite_produit',
            'orders.mode_paiement',
            'orders.prix_produit',
            'products.id AS product_id',
            'products.name AS product_name',
            'payment_transactions.status as payment_status'
        );

    // Filtrer par le terme de recherche si présent
    if ($searchTerm) {
        $ordersQuery->where('orders.red_order', 'LIKE', '%' . $searchTerm . '%');
    }

    // Trier par date de commande en ordre décroissant
    $ordersQuery->orderBy('orders.date_order', 'desc');

    // Récupérer les commandes avec pagination
    $orders = $ordersQuery->paginate(20);

    // Regrouper les commandes par 'red_order'
    $groupedOrders = $orders->getCollection()->groupBy('red_order');

    // Ajouter les totaux calculés pour chaque groupe
    foreach ($groupedOrders as $red_order => $ordersGroup) {
        $totalSubtotal = 0;
        $totalItems = 0;

        foreach ($ordersGroup as $order) {
            $subtotal = $order->prix_produit * $order->quantite_produit;
            $totalSubtotal += $subtotal;
            $totalItems += $order->quantite_produit;

            $total = $subtotal + $frais_livraison + $frais_fiscal;

            $order->subtotal = $subtotal;
            $order->total = $total;

            // Ajouter le statut de paiement pour les commandes par carte
            if ($order->mode_paiement === 'carte') {
                $order->payment_status = $order->payment_status ?? 'pending';
            } else {
                $order->payment_status = 'not_applicable';
            }
        }

        $groupedOrders[$red_order]->totalSubtotal = $totalSubtotal + $frais_livraison + $frais_fiscal;
        $groupedOrders[$red_order]->totalItems = $totalItems;
    }

    // Passer les données à la vue
    return view('dashboard.commandes', compact('groupedOrders', 'orders'));
}


    public function show($red_order)
    {
        // Frais fixes
        $frais_livraison = 8;
        $frais_fiscal = 1;
    
        // Récupérer les commandes avec leurs produits associés pour un red_order spécifique
        $orders = DB::table('orders')
                    ->join('products', 'orders.id_produit', '=', 'products.id')
                    ->select(
                        'orders.id AS order_id',  
                        'orders.red_order',
                        'orders.nom',
                        'orders.prenom',
                        'orders.telephone',
                        'orders.email',
                        'orders.date_order',
                        'orders.status',
                        'orders.adress',
                        'orders.mode_paiement',
                        'orders.quantite_produit',
                        'orders.prix_produit',
                        'products.id AS product_id',  
                        'products.name AS product_name',
                        'products.additional_links AS product_image'
                    )
                    ->where('orders.red_order', $red_order)
                    ->get();
    
        // Calculer les totaux
        $totalSubtotal = 0;
        $totalItems = 0;
    
        foreach ($orders as $order) {
            $subtotal = $order->prix_produit * $order->quantite_produit;
            $totalSubtotal += $subtotal;
            $totalItems += $order->quantite_produit;
            
            $order->subtotal = $subtotal;
            $order->total = $subtotal + $frais_livraison + $frais_fiscal;
        }
    
        $grandTotal = $totalSubtotal + $frais_livraison + $frais_fiscal;
    
        return view('dashboard.detail-commande', compact('orders', 'red_order', 'totalSubtotal', 'grandTotal', 'frais_livraison', 'frais_fiscal', 'totalItems'));
    }


     // Mettre à jour le statut d'une commande
     public function updateStatusOrder(Request $request, $red_order)
     {
         // Valider les données
         $request->validate([
             'status' => 'required|string|in:encours,traite,annule', // Correction des statuts pour correspondre à la base de données
         ]);
     
         // Récupérer la commande spécifique par red_order
         $order = DB::table('orders')
                    ->where('red_order', $red_order)
                    ->first();
     
         // Vérifier si la commande existe
         if (!$order) {
             return redirect()->route('dashboard.commandes')->with('error', 'Aucune commande trouvée avec cet ID.');
         }
     
         // Mettre à jour le statut de la commande
         DB::table('orders')
             ->where('red_order', $red_order)
             ->update(['status' => $request->status]);
     
         return redirect()->route('dashboard.commandes')->with('success', 'Statut de la commande mis à jour.');
     }
     
 

  
public function updateOrder(Request $request)
{
    // Valider la requête
    $request->validate([
        'order' => 'required|array', // Vérifier que `order` est un tableau
    ]);

    // Récupérer l'ordre des IDs
    $order = $request->input('order');

    // Mettre à jour l'ordre de chaque produit
    foreach ($order as $index => $productId) {
        DB::table('products')
            ->where('id', $productId)
            ->update(['order' => $index + 1]); // Mettre à jour la colonne `order`
    }

    // Retourner une réponse JSON
    return response()->json([
        'success' => true,
        'message' => 'Ordre mis à jour avec succès !',
    ]);
}
 



public function clients(Request $request)
{
    $search = $request->input('search');

    $clientsQuery = DB::table('orders')
        ->select(
            'orders.nom',
            'orders.prenom',
            'orders.email',
            'orders.telephone',
            DB::raw('COUNT(DISTINCT orders.red_order) as nombre_commandes'),
            DB::raw('MAX(orders.date_order) as derniere_commande')
        )
        ->groupBy('orders.nom', 'orders.prenom', 'orders.email', 'orders.telephone')
        ->orderBy('nombre_commandes', 'DESC');

    if ($search) {
        $clientsQuery->havingRaw("CONCAT(orders.prenom, ' ', orders.nom) LIKE ?", ["%$search%"]);
    }

    $clients = $clientsQuery->paginate(10)->appends(['search' => $search]);

    return view('dashboard.clients', compact('clients', 'search'));
}

   public function commandesClient($email)
{
    // Récupérer les commandes groupées par red_order pour un client spécifique
    $orders = DB::table('orders')
                ->join('products', 'orders.id_produit', '=', 'products.id')
                ->select(
                    'orders.*',
                    'products.name AS product_name' 
                )
                ->where('orders.email', $email)
                ->get()
                ->groupBy('red_order');

    $client = DB::table('orders')
                ->where('email', $email)
                ->select('nom', 'prenom', 'email', 'telephone')
                ->first();

    return view('dashboard.commandes-client', compact('orders', 'client'));
}




public function exportPdf($red_order)
{
    $ordersGroup = DB::table('orders')
        ->join('products', 'orders.id_produit', '=', 'products.id')
        ->select(
            'orders.red_order',
            'orders.nom',
            'orders.prenom',
            'orders.telephone',
            'orders.email',
            'orders.date_order',
            'orders.adress',
            'orders.gouvernorat',
            'orders.quantite_produit',
            'orders.prix_produit',
            'products.name AS produit'
        )
        ->where('orders.red_order', $red_order)
        ->get();

    if ($ordersGroup->isEmpty()) {
        abort(404, 'Commande introuvable.');
    }

    // Ajouter total et prix_unitaire dans chaque élément
    foreach ($ordersGroup as $order) {
        $order->quantite = $order->quantite_produit;
        $order->prix_unitaire = $order->prix_produit;
        $order->total = $order->quantite * $order->prix_unitaire;
    }

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.commande-pdf', [
        'ordersGroup' => $ordersGroup,
        'red_order' => $red_order
    ]);

    return $pdf->stream("commande-{$red_order}.pdf");
}

public function groupedOrders(Request $request)
{
    $query = Order::query();

    // Recherche
    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('red_order', 'like', "%{$search}%")
              ->orWhere('nom', 'like', "%{$search}%")
              ->orWhere('prenom', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('telephone', 'like', "%{$search}%");
        });
    }

    // Récupérer les commandes groupées
    $orders = $query->orderBy('date_order', 'desc')->get();
    $groupedOrders = $orders->groupBy('red_order');

    // Pagination manuelle
    $page = $request->get('page', 1);
    $perPage = 10;
    $total = $groupedOrders->count();
    $groupedOrders = $groupedOrders->forPage($page, $perPage);

    // Créer une instance de LengthAwarePaginator
    $orders = new \Illuminate\Pagination\LengthAwarePaginator(
        $groupedOrders,
        $total,
        $perPage,
        $page,
        ['path' => $request->url(), 'query' => $request->query()]
    );

    return view('dashboard.commandes', compact('groupedOrders', 'orders'));
}

public function updateBulkStatus(Request $request)
{
    $request->validate([
        'order_ids' => 'required|array',
        'order_ids.*' => 'required|string',
        'status' => 'required|in:encours,traite,annule' // Correction des statuts pour correspondre à la base de données
    ]);

    try {
        DB::beginTransaction();

        foreach ($request->order_ids as $red_order) {
            Order::where('red_order', $red_order)
                ->update(['status' => $request->status]);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Statuts mis à jour avec succès'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la mise à jour des statuts: ' . $e->getMessage()
        ], 500);
    }
}

public function destroy($red_order)
{
    try {
        DB::beginTransaction();

        // Delete all orders with the given red_order
        $deleted = Order::where('red_order', $red_order)->delete();

        if ($deleted === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Commande introuvable'
            ], 404);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Commande supprimée avec succès'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la suppression de la commande: ' . $e->getMessage()
        ], 500);
    }
}




}