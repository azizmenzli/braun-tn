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

use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function processOrder(Request $request)
    {
        // --- Step 1: Validate basic fields and that 'products' is a valid JSON string ---
        $initialValidator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required|regex:/^\+?[0-9]{8,15}$/',
            'gouvernorat' => 'required|string',
            'adress' => 'required|string',
            'products' => 'required|string|json', // Expect a JSON string
            'mode_paiement' => 'required|in:espace,carte',
            // Optional fields validation (adjust as needed)
            'sex' => 'nullable|in:male,female,other',
            'date_naissance' => 'nullable|date|before_or_equal:today',
        ]);

        if ($initialValidator->fails()) {
            Log::error('Initial validation failed', ['errors' => $initialValidator->errors()]);
            // Return with specific errors for the initial fields
            return back()->withErrors($initialValidator)->withInput();
        }

        // --- Step 2: Decode the products JSON string ---
        $productsInput = $request->input('products');
        $productsArray = json_decode($productsInput, true); // Decode into an associative array

        // Check if decoding was successful and if it's a non-empty array
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($productsArray) || empty($productsArray)) {
            Log::error('Products JSON decoding failed or empty array', [
                'products_input' => $productsInput,
                'json_error' => json_last_error_msg()
            ]);
            // Add a specific error for the products field
            return back()->withErrors(['products' => 'Les données du panier sont invalides ou vides.'])
                         ->withInput();
        }

        // --- Step 3: Validate the content of the decoded products array ---
        // We create a temporary data structure to validate the array content
        $productsDataForValidation = ['products' => $productsArray];
        $productsValidator = Validator::make($productsDataForValidation, [
            'products' => 'required|array|min:1', // Ensure it's an array with at least one item
            'products.*.product_id' => 'required|integer|exists:products,id', // Validate each item
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        if ($productsValidator->fails()) {
            Log::error('Products content validation failed', ['errors' => $productsValidator->errors()]);
            // Return with specific errors for the products items
            return back()->withErrors($productsValidator)->withInput(); // Laravel can handle nested errors display
        }


        // --- Step 4: Proceed with order processing using the validated $productsArray ---
        DB::beginTransaction();
        try {
            $redOrder = 'ORD-' . strtoupper(uniqid());
            $sourceCommande = 'web';
            $ipClient = $request->ip();
            $deviceClient = $this->detectDevice($request);
            $orders = []; // To collect created orders for the email

            // Use the decoded and validated $productsArray
            $productsCollection = collect($productsArray)->map(function ($item) {
                 return [
                    'product_id' => (int)$item['product_id'],
                    'quantity' => (int)$item['quantity'],
                    'price' => (float)$item['price']
                 ];
            });


            foreach ($productsCollection as $productData) {
                // Vérification du stock avec lockForUpdate pour éviter les conflits
                $produit = Product::where('id', $productData['product_id'])
                    ->lockForUpdate()
                    ->first(); // Use first() instead of get() when expecting one result

                // Check if product exists *and* has enough stock
                if (!$produit) {
                    DB::rollBack();
                    Log::error('Product not found during order processing', ['product_id' => $productData['product_id']]);
                    return back()
                        ->with('error', 'Un produit de votre commande n\'existe plus.')
                        ->withInput();
                }
                if ($produit->quantity < $productData['quantity']) {
                    DB::rollBack();
                    Log::error('Stock insuffisant', [
                        'product_id' => $productData['product_id'],
                        'product_name' => $produit->name, // Log name for clarity
                        'requested' => $productData['quantity'],
                        'available' => $produit->quantity
                    ]);
                    return back()
                        ->with('error', 'Le produit "'.$produit->name.'" n\'a pas suffisamment de stock (Disponible: '.$produit->quantity.', Demandé: '.$productData['quantity'].')')
                        ->withInput();
                }

                // Mise à jour du stock
                $produit->decrement('quantity', $productData['quantity']);
                // $produit->save(); // decrement already saves

                $order = Order::create([
                    'red_order' => $redOrder,
                    'nom' => $request->nom,
                    'prenom' => $request->prenom,
                    'email' => $request->email,
                    'telephone' => $request->telephone,
                    'gouvernorat' => $request->gouvernorat,
                    'adress' => $request->adress,
                    'sex' => $request->sex, // Make sure 'sex' is nullable in migration if not required
                    'date_naissance' => $request->date_naissance, // Make sure 'date_naissance' is nullable
                    'date_order' => now(),
                    'id_produit' => $productData['product_id'],
                    'prix_produit' => $productData['price'], // Use price from validated data
                    'quantite_produit' => $productData['quantity'], // Use quantity from validated data
                    'mode_paiement' => $request->mode_paiement,
                    'source_commande' => $sourceCommande,
                    'ip_client' => $ipClient,
                    'device_client' => $deviceClient,
                    'status' => 'encours' // Default status
                ]);

                $orders[] = $order; // Add the created order to the list for the email
            }

            DB::commit(); // Commit transaction only if all products are processed successfully

            // Send email (Consider queuing this for better performance in production)
            try {
                Mail::to($request->email)->send(new ClientOrderMail($orders)); 
        
                // Send email to all admin users
                $adminUsers = User::where('utype', 'ADM')->whereNotNull('email')->get();
                foreach ($adminUsers as $user) {
                    // Load the product relationship for the first order
                    $orderWithProduct = $orders[0]->load('product');
                    Mail::to($user->email)->send(new AdminOrderMail($orderWithProduct));
                }

                Log::info('Order confirmation email sent successfully', [
                    'red_order' => $redOrder, 
                    'email' => $request->email,
                    'admin_count' => count($adminUsers)
                ]);
            } catch (\Exception $mailException) {
                 Log::error('Failed to send order confirmation email', [
                     'red_order' => $redOrder,
                     'email' => $request->email,
                     'error' => $mailException->getMessage()
                 ]);
                 // Don't rollback the transaction, the order is placed, just log the email issue.
                 // Optionally, notify admin.
            }

         
            return redirect()->route('confirmation', ['redOrder' => $redOrder])
                ->with('success', 'Commande passée avec succès ! Un email de confirmation vous a été envoyé.')
                ->with('clearCart', true); // Add a flag for JS on confirmation page

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on any exception during processing
            Log::error('Erreur commande: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            // Provide a generic error message to the user
            return back()->with('error', 'Une erreur technique est survenue lors du traitement de votre commande. Veuillez réessayer.')->withInput();
        }
    }

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

 public function index()
    {
       // Frais fixes
       $frais_livraison = 8;
       $frais_fiscal = 1;
   
       // Récupérer les commandes avec leurs produits associés
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
                       'orders.gouvernorat',
                       'orders.quantite_produit',
                       'orders.prix_produit',
                       'products.id AS product_id',  
                       'products.name AS product_name'
                   )
                   ->get();
   
       // Regrouper les commandes par 'red_order'
       $groupedOrders = $orders->groupBy('red_order');
   
       // Ajouter les totaux calculés pour chaque groupe
       foreach ($groupedOrders as $red_order => $ordersGroup) {
           // Initialiser le sous-total et le total pour chaque red_order
           $totalSubtotal = 0;
           $totalItems = 0;
   
           foreach ($ordersGroup as $order) {
               // Calculer le sous-total pour les produits dans chaque commande
               $subtotal = $order->prix_produit * $order->quantite_produit;
               $totalSubtotal += $subtotal;  // Ajouter au sous-total général du red_order
               $totalItems += $order->quantite_produit;  // Compter le nombre d'articles
   
               // Calcul du total avec les frais fixes pour chaque commande
               $total = $subtotal + $frais_livraison + $frais_fiscal;
               
               // Ajouter les résultats de calcul dans chaque commande
               $order->subtotal = $subtotal;
               $order->total = $total;
           }
   
           // Ajouter les totaux (frais inclus) au red_order
           $groupedOrders[$red_order]->totalSubtotal = $totalSubtotal + $frais_livraison + $frais_fiscal;
           $groupedOrders[$red_order]->totalItems = $totalItems;
       }
   
       // Passer les données à la vue
       return view('dashboard.commandes', compact('groupedOrders'));

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
                        'products.name AS product_name'
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
           'status' => 'required|string|in:encours,traité,annulé', // Les statuts possibles
       ]);
 
       // Récupérer la commande spécifique par order_id
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
 




   public function clients()
   {
       // Récupérer la liste des clients avec leur nombre de commandes
       $clients = DB::table('orders')
                   ->select(
                       'orders.nom',
                       'orders.prenom',
                       'orders.email',
                       'orders.telephone',
                       DB::raw('COUNT(DISTINCT orders.red_order) as nombre_commandes'),
                       DB::raw('MAX(orders.date_order) as derniere_commande')
                   )
                   ->groupBy('orders.nom', 'orders.prenom', 'orders.email', 'orders.telephone')
                   ->orderBy('nombre_commandes', 'DESC')
                   ->get();
   
       return view('dashboard.clients', compact('clients'));
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







}