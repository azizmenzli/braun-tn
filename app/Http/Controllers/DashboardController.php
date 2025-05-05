<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\user;
use Illuminate\Support\Facades\Hash; // Importez cette ligne
use App\Models\Coupon;
use App\Models\Demande_revendeur;
use Illuminate\Support\Str;   
use Carbon\Carbon;           
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;  
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\VisitorLog;
 use Jenssegers\Agent\Agent;
 use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\Password;
 use App\Mail\ClientOrderMail; // Mail pour le client
 use App\Mail\AdminOrderMail; // Mail pour le client
 use Illuminate\Support\Facades\Mail;
 use ArielMejiaDev\LarapexCharts\LarapexChart;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
     
      

    public function index()
    {
        // Récupérer les statistiques globales
        $totalOrders = Order::distinct('red_order')->count('red_order');
        $totalAmount = Order::sum(DB::raw('prix_produit * quantite_produit'));
    
        // Statistiques par statut
        $statuses = ['encours', 'traité', 'annulé'];
        $statusData = [];
        foreach ($statuses as $status) {
            $orders = Order::where('status', $status)->get();
            $totalSubtotal = 0;
            $totalItems = 0;
    
            foreach ($orders as $order) {
                $subtotal = $order->prix_produit * $order->quantite_produit;
                $totalSubtotal += $subtotal;
                $totalItems += $order->quantite_produit;
            }
    
            $statusData[$status] = [
                'order_count' => $orders->count(),
                'total_amount' => $totalSubtotal,
                'total_items' => $totalItems,
            ];
        }
    
        // Statistiques pour les modes de paiement
        $paymentData = Order::select('mode_paiement', DB::raw('COUNT(DISTINCT red_order) as count'))
            ->groupBy('mode_paiement')
            ->pluck('count', 'mode_paiement');
    
        // Statistiques pour les sources de commande
        $sourceData = Order::select('source_commande', DB::raw('COUNT(DISTINCT red_order) as count'))
        ->groupBy('source_commande')
        ->pluck('count', 'source_commande');

    $total = $sourceData->sum();
    
    $sourceDataPercent = $sourceData->map(function ($count) use ($total) {
        return round(($count / $total) * 100);
    });
        // Données pour la carte des IP
        $ipData = Order::select('ip_client')
            ->distinct()
            ->pluck('ip_client');
        $totalRevenue = Order::sum('prix_produit'); // Montant total des produits commandés
    
        // Calculer les revenus de la dernière période (exemple : la semaine dernière)
        $lastWeekRevenue = Order::where('date_order', '>=', now()->subWeek())->sum('prix_produit');
        $lastWeekOrders = Order::where('date_order', '>=', now()->subWeek())->count();
    
        // Calculer les pourcentages de variation par rapport à la période précédente
        $revenuePercentage = $totalRevenue > 0 ? (($lastWeekRevenue - $totalRevenue) / $totalRevenue) * 100 : 0;
        $orderPercentage = $totalOrders > 0 ? (($lastWeekOrders - $totalOrders) / $totalOrders) * 100 : 0;
    
        // Récupérer les statistiques mensuelles
        $currentYear = date('Y');
        $monthlyTotalOrders = Order::selectRaw('COUNT(DISTINCT red_order) as total_orders, strftime("%m", created_at) as month')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    
        $monthlyPendingOrders = Order::where('status', 'encours')
            ->selectRaw('COUNT(DISTINCT red_order) as pending_orders, strftime("%m", created_at) as month')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    
        $monthlyDeliveredOrders = Order::where('status', 'traité')
            ->selectRaw('COUNT(DISTINCT red_order) as delivered_orders, strftime("%m", created_at) as month')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    
        $monthlyCanceledOrders = Order::where('status', 'annulé')
            ->selectRaw('COUNT(DISTINCT red_order) as canceled_orders, strftime("%m", created_at) as month')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    
        // Fetch the sex distribution with counts (grouped by red_order)
        $sexDistribution = Order::selectRaw('sex, count(distinct red_order) as count')
            ->groupBy('sex')
            ->get();
    
        // Define age ranges and their labels
        $ageRanges = [
            '18-20' => [18, 20],
            '20-22' => [20, 22],
            '22-25' => [22, 25],
            '25-30' => [25, 30],
            '30-35' => [30, 35],
            '35-40' => [35, 40],
            '40-50' => [40, 50],
            '50+' => [50, 100],  // Consider all ages 50 and above as the last range
        ];
    
        // Initialize an array to store the age distribution counts
        $ageDistribution = [];
    
        // Loop through each age range and get the count of orders for that range
        foreach ($ageRanges as $label => [$minAge, $maxAge]) {
            $ageDistribution[$label] = Order::selectRaw('count(*) as count')
                ->whereRaw('FLOOR((julianday("now") - julianday(date_naissance)) / 365.25) BETWEEN ? AND ?', [$minAge, $maxAge])
                ->count();
        }
    
     // Calculer les produits populaires en fonction du total des quantités vendues
    $topProducts = Order::select('id_produit', DB::raw('SUM(quantite_produit) as total_quantity_sold'))
    ->groupBy('id_produit') // Regrouper par produit
    ->orderByDesc('total_quantity_sold') // Trier par quantité totale vendue (du plus grand au plus petit)
    ->limit(5) // Limiter à 5 produits
    ->get();
    
    // Récupérer les détails des produits populaires
    $topProductsDetails = Product::whereIn('id', $topProducts->pluck('id_produit'))
    ->get();
    
    // Récupérer les commandes récentes
    $orders = Order::latest()->limit(5)->get();
    
    $topSKU = DB::table('orders')
    ->join('products', 'orders.id_produit', '=', 'products.id')
    ->select(
        'products.SKU', 
        'products.name', 
        DB::raw('SUM(orders.quantite_produit) as total_quantity_sold'),
        DB::raw('SUM(orders.quantite_produit * orders.prix_produit) as total_revenue')
    )
    ->groupBy('products.SKU', 'products.name')
    ->orderByDesc('total_revenue')
    ->limit(10)
    ->get();
    
    $topOrders = Order::select(
        'red_order as reference_commande',
        DB::raw('(nom || " " || prenom) AS nom_client'),
        DB::raw('SUM(prix_produit * quantite_produit) AS chiffre_affaires')
    )
    ->groupBy('red_order', 'nom', 'prenom')
    ->orderBy('chiffre_affaires', 'desc')
    ->limit(10)
    ->get();

    // Commandes pour cette semaine
    $thisWeekOrders = Order::selectRaw('strftime("%Y", date_order) as year, strftime("%m", date_order) as month, COUNT(*) as count')
        ->where('date_order', '>=', now()->startOfWeek())
        ->where('date_order', '<=', now()->endOfWeek())
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();
    
    // Commandes pour la semaine dernière
    $lastWeekOrders = Order::selectRaw('strftime("%Y", date_order) as year, strftime("%m", date_order) as month, COUNT(*) as count')
        ->where('date_order', '>=', now()->subWeek()->startOfWeek())
        ->where('date_order', '<=', now()->subWeek()->endOfWeek())
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

    // Formater les données pour Google Charts
    $thisWeekData = $thisWeekOrders->map(function ($order) {
    return [\Carbon\Carbon::createFromDate($order->year, $order->month, 1)->format('M Y'), $order->count];
    });
    
    $lastWeekData = $lastWeekOrders->map(function ($order) {
    return [\Carbon\Carbon::createFromDate($order->year, $order->month, 1)->format('M Y'), $order->count];
    });

    $ventesParMois = [];
    $produitsParMois = [];

    for ($i = 1; $i <= 12; $i++) {
        $ventesParMois[] = Order::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->count();
        $produitsParMois[] = Product::whereMonth('created_at', $i)->whereYear('created_at', date('Y'))->count();
    }



    $ventesParCategorie = DB::table('orders')
    ->join('products', 'orders.id_produit', '=', 'products.id')
    ->join('categories', 'products.category_id', '=', 'categories.id')
    ->select('categories.name', DB::raw('COUNT(*) as total'))
    ->groupBy('categories.name')
    ->get();

$labels = $ventesParCategorie->pluck('name');
$data = $ventesParCategorie->pluck('total');

$stats = DB::table('orders')
->select('gouvernorat', DB::raw('COUNT(DISTINCT red_order) as nombre_commandes'))
->groupBy('gouvernorat')
->get();
 

        // Passer les données à la vue
        return view('dashboard.index', [
            'totalOrders' => $totalOrders,
            'totalAmount' => $totalAmount,
            'statusData' => $statusData,
            'paymentData' => $paymentData,
            'sourceDataPercent' => $sourceDataPercent,
            'ipData' => $ipData,
            'totalRevenue' => $totalRevenue,
            'lastWeekRevenue' => $lastWeekRevenue,
            'lastWeekOrders' => $lastWeekOrders,
            'revenuePercentage' => $revenuePercentage,
            'orderPercentage' => $orderPercentage,
            'monthlyTotalOrders' => $monthlyTotalOrders,
            'monthlyPendingOrders' => $monthlyPendingOrders,
            'monthlyDeliveredOrders' => $monthlyDeliveredOrders,
            'monthlyCanceledOrders' => $monthlyCanceledOrders,
            'sexDistribution' => $sexDistribution,
            'ageDistribution' => $ageDistribution,
            'topProducts' => $topProducts,
    'orders' => $orders,
    'topSKU'=>$topSKU,
    'topOrders'=>$topOrders,
    'thisWeekData'=>$thisWeekData,
    'lastWeekData'=>$lastWeekData,
    'ventesParMois'=>$ventesParMois,
    'produitsParMois'=>$produitsParMois,
    'labels'=>$labels, 
    'data'=>$data,
    'stats' => $stats
    
         ]);
    }
       
    





}
 
