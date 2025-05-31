<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
use App\Mail\ClientOrderMail;
use App\Mail\AdminOrderMail;
use Illuminate\Support\Facades\Mail;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $dateStartInput = $request->input('date_start');
        $dateEndInput = $request->input('date_end');

        // Fonction pour appliquer le filtre de date
        $applyDateFilter = function ($query, $dateColumn = 'created_at') use ($dateStartInput, $dateEndInput) {
            if ($dateStartInput) {
                try {
                    $startDate = Carbon::parse($dateStartInput)->startOfDay();
                    if ($dateEndInput) {
                        $endDate = Carbon::parse($dateEndInput)->endOfDay();
                        $query->whereBetween($dateColumn, [$startDate, $endDate]);
                    } else {
                        $query->whereDate($dateColumn, $startDate);
                    }
                } catch (\Exception $e) {
                    // Gérer l'erreur de date si nécessaire
                }
            }
            return $query;
        };

        // 1. Total Commandes reçues
        $totalOrdersQuery = Order::query();
        $totalOrdersQuery = $applyDateFilter($totalOrdersQuery);
        $totalOrders = $totalOrdersQuery->distinct('red_order')->count('red_order');

        // 2. Montant total (sur la période filtrée ou global)
        $totalAmountQuery = Order::query();
        $totalAmountQuery = $applyDateFilter($totalAmountQuery);
        $totalAmount = $totalAmountQuery->sum(DB::raw('prix_produit * quantite_produit'));

        // 3. Statistiques par statut (encours, traité, annulé)
        $statuses = ['encours', 'traité', 'annulé'];
        $statusData = [];
        foreach ($statuses as $status) {
            $statusBaseQuery = Order::where('status', $status);
            $statusBaseQuery = $applyDateFilter($statusBaseQuery);

            $ordersForStatus = $statusBaseQuery
                ->groupBy('red_order')
                ->select(
                    'red_order',
                    DB::raw('SUM(prix_produit * quantite_produit) as total_amount'),
                    DB::raw('SUM(quantite_produit) as total_items')
                )
                ->get();

            $statusData[$status] = [
                'order_count' => $ordersForStatus->count(),
                'total_amount' => $ordersForStatus->sum('total_amount'),
                'total_items' => $ordersForStatus->sum('total_items'),
            ];
        }

        // 4. Nouveaux clients (Clients uniques sur la période ou global)
        $totalClientsQuery = Order::query();
        $totalClientsQuery = $applyDateFilter($totalClientsQuery);
        $totalClients = $totalClientsQuery->distinct('email')->count('email');

        // Pourcentage de variation des commandes (vs semaine précédente)
        $orderPercentage = null;
        if (!$dateStartInput) {
            $ordersThisWeek = Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                   ->distinct('red_order')->count();
            $ordersLastWeek = Order::whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
                                   ->distinct('red_order')->count();

            if ($ordersLastWeek > 0) {
                $orderPercentage = (($ordersThisWeek - $ordersLastWeek) / $ordersLastWeek) * 100;
            } elseif ($ordersThisWeek > 0) {
                $orderPercentage = 100;
            } else {
                $orderPercentage = 0;
            }
        }

        // Graphique: Statistiques de ventes par mois
        $yearForMonthlyCharts = $dateStartInput ? Carbon::parse($dateStartInput)->year : Carbon::now()->year;
        $ventesParMois = array_fill(0, 12, 0);
        $produitsParMois = array_fill(0, 12, 0);

        for ($i = 1; $i <= 12; $i++) {
            $queryForMonthVentes = Order::whereYear('created_at', $yearForMonthlyCharts)->whereMonth('created_at', $i);
            $queryForMonthVentes = $applyDateFilter($queryForMonthVentes);
            $ventesParMois[$i-1] = $queryForMonthVentes->distinct('red_order')->count('red_order');

            $queryForMonthProduitsVendus = Order::whereYear('created_at', $yearForMonthlyCharts)->whereMonth('created_at', $i);
            $queryForMonthProduitsVendus = $applyDateFilter($queryForMonthProduitsVendus);
            $produitsParMois[$i-1] = $queryForMonthProduitsVendus->distinct('id_produit')->count('id_produit');
        }

        // Graphique: Catégorie la plus vendue (amélioré)
        $ventesParCategorieQuery = DB::table('orders')
            ->join('products', 'orders.id_produit', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name',
                DB::raw('COUNT(DISTINCT orders.red_order) as total_orders'),
                DB::raw('SUM(orders.quantite_produit) as total_quantity'),
                DB::raw('SUM(orders.quantite_produit * orders.prix_produit) as total_revenue')
            )
            ->groupBy('categories.name')
            ->orderByDesc('total_orders');

        $ventesParCategorieQuery = $applyDateFilter($ventesParCategorieQuery, 'orders.created_at');
        $ventesParCategorie = $ventesParCategorieQuery->get();

        $labelsCategorie = $ventesParCategorie->pluck('name');
        $dataCategorie = $ventesParCategorie->pluck('total_orders');
        $revenueCategorie = $ventesParCategorie->pluck('total_revenue');

        // Distribution par sexe
        $sexDistributionQuery = Order::query();
        $sexDistributionQuery = $applyDateFilter($sexDistributionQuery);
        $sexDistribution = $sexDistributionQuery->selectRaw('sex, count(distinct red_order) as count')
            ->groupBy('sex')
            ->get();

        // TOP SKU Vente
        $topSKUQuery = DB::table('orders')
            ->join('products', 'orders.id_produit', '=', 'products.id');
        $topSKUQuery = $applyDateFilter($topSKUQuery, 'orders.created_at');
        $topSKU = $topSKUQuery->select(
                'products.SKU',
                'products.name',
                DB::raw('SUM(orders.quantite_produit) as total_quantity_sold'),
                DB::raw('SUM(orders.quantite_produit * orders.prix_produit) as total_revenue')
            )
            ->groupBy('products.SKU', 'products.name')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();

        // Distribution par âge (amélioré)
        $ageOrderQuery = Order::query();
        $ageOrderQuery = $applyDateFilter($ageOrderQuery);
        
        // Nouvelle requête pour la distribution par âge et catégorie
        $ageCategoryDistribution = DB::table('orders')
            ->join('products', 'orders.id_produit', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name as category_name',
                'orders.date_naissance',
                DB::raw('COUNT(DISTINCT orders.red_order) as order_count')
            )
            ->whereNotNull('orders.date_naissance')
            ->groupBy('categories.name', 'orders.date_naissance');

        $ageCategoryDistribution = $applyDateFilter($ageCategoryDistribution, 'orders.created_at');
        $ageCategoryDistribution = $ageCategoryDistribution->get();

        $ageRanges = [
            '18-20' => [18, 20],
            '21-25' => [21, 25],
            '26-30' => [26, 30],
            '31-35' => [31, 35],
            '36-40' => [36, 40],
            '41-50' => [41, 50],
            '50+' => [51, 150]
        ];

        $ageDistribution = array_fill_keys(array_keys($ageRanges), 0);
        $ageRevenue = array_fill_keys(array_keys($ageRanges), 0);
        $ageCategoryData = [];

        // Initialiser les données par catégorie
        foreach ($ventesParCategorie as $category) {
            $ageCategoryData[$category->name] = array_fill_keys(array_keys($ageRanges), 0);
        }

        foreach($ageCategoryDistribution as $record) {
            try {
                $birthDate = Carbon::parse($record->date_naissance);
                $age = $birthDate->age;
                
                foreach ($ageRanges as $label => [$minAge, $maxAge]) {
                    if ($age >= $minAge && $age <= $maxAge) {
                        $ageDistribution[$label] += $record->order_count;
                        
                        // Ajouter le compte pour cette catégorie
                        if (isset($ageCategoryData[$record->category_name])) {
                            $ageCategoryData[$record->category_name][$label] += $record->order_count;
                        }
                        
                        // Calculer le revenu pour cette tranche d'âge
                        $revenueForAge = $ageOrderQuery->clone()
                            ->where('date_naissance', $record->date_naissance)
                            ->sum(DB::raw('prix_produit * quantite_produit'));
                            
                        $ageRevenue[$label] += $revenueForAge;
                        break;
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        // Commandes Récentes/Top (Top 10 par CA)
        $topOrdersQuery = Order::query();
        $topOrdersQuery = $applyDateFilter($topOrdersQuery);
        $topOrders = $topOrdersQuery->select(
                'red_order AS reference_commande',
                DB::raw('CONCAT(nom, " ", prenom) AS nom_client'),
                DB::raw('SUM(prix_produit * quantite_produit) AS chiffre_affaires')
            )
            ->groupBy('red_order', 'nom', 'prenom')
            ->orderByDesc('chiffre_affaires')
            ->limit(10)
            ->get();

        // Sources de Traffic
        $sourceDataQuery = Order::query();
        $sourceDataQuery = $applyDateFilter($sourceDataQuery);
        $sourceData = $sourceDataQuery->select('source_commande', DB::raw('COUNT(DISTINCT red_order) as count'))
            ->groupBy('source_commande')
            ->pluck('count', 'source_commande');
        $totalSourceSum = $sourceData->sum();
        $sourceDataPercent = $sourceData->map(function ($count) use ($totalSourceSum) {
            return $totalSourceSum > 0 ? round(($count / $totalSourceSum) * 100) : 0;
        });

        // Comparaison Commandes Semestrielles
        $refDateForWeekly = $dateStartInput ? Carbon::parse($dateStartInput) : now();
        $thisWeekData = [];
        $lastWeekData = [];

        for ($m = 0; $m < 6; $m++) {
            $currentMonthRef = $refDateForWeekly->copy()->subMonths($m);

            $startOfWeekThis = $currentMonthRef->copy()->startOfWeek();
            $endOfWeekThis = $currentMonthRef->copy()->endOfWeek();
            $queryThisWeek = Order::whereBetween('created_at', [$startOfWeekThis, $endOfWeekThis]);
            $queryThisWeek = $applyDateFilter($queryThisWeek);
            $countThisWeek = $queryThisWeek->distinct('red_order')->count();
            $thisWeekData[] = [$currentMonthRef->format('M Y'), $countThisWeek];

            $startOfWeekLast = $currentMonthRef->copy()->subWeek()->startOfWeek();
            $endOfWeekLast = $currentMonthRef->copy()->subWeek()->endOfWeek();
            $queryLastWeek = Order::whereBetween('created_at', [$startOfWeekLast, $endOfWeekLast]);
            $queryLastWeek = $applyDateFilter($queryLastWeek);
            $countLastWeek = $queryLastWeek->distinct('red_order')->count();
            $lastWeekData[] = [$currentMonthRef->format('M Y'), $countLastWeek];
        }

        $thisWeekData = array_reverse($thisWeekData);
        $lastWeekData = array_reverse($lastWeekData);

        // État des commandes par mois
        $yearForMonthlyStatus = $dateStartInput ? Carbon::parse($dateStartInput)->year : Carbon::now()->year;
        $monthlyTotalOrders = array_fill(1, 12, 0);
        $monthlyPendingOrders = array_fill(1, 12, 0);
        $monthlyDeliveredOrders = array_fill(1, 12, 0);
        $monthlyCanceledOrders = array_fill(1, 12, 0);

        for ($i = 1; $i <= 12; $i++) {
            $baseMonthlyQuery = Order::whereYear('created_at', $yearForMonthlyStatus)->whereMonth('created_at', $i);
            $baseMonthlyQuery = $applyDateFilter(clone $baseMonthlyQuery);

            $monthlyTotalOrders[$i] = (clone $baseMonthlyQuery)->distinct('red_order')->count();
            $monthlyPendingOrders[$i] = (clone $baseMonthlyQuery)->where('status', 'encours')->distinct('red_order')->count();
            $monthlyDeliveredOrders[$i] = (clone $baseMonthlyQuery)->where('status', 'traité')->distinct('red_order')->count();
            $monthlyCanceledOrders[$i] = (clone $baseMonthlyQuery)->where('status', 'annulé')->distinct('red_order')->count();
        }

        // Commandes par Mode de Paiement
        $paymentDataQuery = Order::query();
        $paymentDataQuery = $applyDateFilter($paymentDataQuery);
        $paymentData = $paymentDataQuery->select('mode_paiement', DB::raw('COUNT(DISTINCT red_order) as count'))
            ->groupBy('mode_paiement')
            ->pluck('count', 'mode_paiement');

        // Commandes par Gouvernorat
        $statsByGouvernoratQuery = Order::query();
        $statsByGouvernoratQuery = $applyDateFilter($statsByGouvernoratQuery);
        $stats = $statsByGouvernoratQuery->select('gouvernorat', DB::raw('COUNT(DISTINCT red_order) as nombre_commandes'))
            ->whereNotNull('gouvernorat')
            ->groupBy('gouvernorat')
            ->orderByDesc('nombre_commandes')
            ->get();

        // Statistiques de retour/traffic
        $trafficReturnStats = DB::table('orders')
            ->select(
                'source_commande',
                DB::raw('COUNT(DISTINCT red_order) as total_orders'),
                DB::raw('COUNT(DISTINCT CASE WHEN status = "annulé" THEN red_order END) as canceled_orders'),
                DB::raw('COUNT(DISTINCT CASE WHEN status = "traité" THEN red_order END) as completed_orders'),
                DB::raw('COUNT(DISTINCT CASE WHEN status = "encours" THEN red_order END) as pending_orders'),
                DB::raw('SUM(CASE WHEN status = "traité" THEN prix_produit * quantite_produit ELSE 0 END) as completed_revenue'),
                DB::raw('SUM(CASE WHEN status = "annulé" THEN prix_produit * quantite_produit ELSE 0 END) as canceled_revenue')
            )
            ->groupBy('source_commande');

        $trafficReturnStats = $applyDateFilter($trafficReturnStats, 'created_at');
        $trafficReturnStats = $trafficReturnStats->get();

        // Calculer les pourcentages et les statistiques supplémentaires
        $trafficReturnData = $trafficReturnStats->map(function ($stat) {
            $totalOrders = $stat->total_orders;
            $canceledOrders = $stat->canceled_orders;
            $completedOrders = $stat->completed_orders;
            $pendingOrders = $stat->pending_orders;

            return [
                'source' => $stat->source_commande,
                'total_orders' => $totalOrders,
                'canceled_orders' => $canceledOrders,
                'completed_orders' => $completedOrders,
                'pending_orders' => $pendingOrders,
                'cancel_rate' => $totalOrders > 0 ? round(($canceledOrders / $totalOrders) * 100, 2) : 0,
                'completion_rate' => $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100, 2) : 0,
                'completed_revenue' => $stat->completed_revenue,
                'canceled_revenue' => $stat->canceled_revenue,
                'avg_order_value' => $totalOrders > 0 ? round($stat->completed_revenue / $totalOrders, 2) : 0
            ];
        });

        return view('dashboard.index', [
            'totalOrders' => $totalOrders,
            'totalAmount' => $totalAmount,
            'statusData' => $statusData,
            'totalClients' => $totalClients,
            'orderPercentage' => $orderPercentage,

            'ventesParMois' => $ventesParMois,
            'produitsParMois' => $produitsParMois,
            'labelsCategorie' => $labelsCategorie,
            'dataCategorie' => $dataCategorie,
            'revenueCategorie' => $revenueCategorie,
            'sexDistribution' => $sexDistribution,
            'topSKU' => $topSKU,
            'ageDistribution' => $ageDistribution,
            'ageRevenue' => $ageRevenue,
            'topOrders' => $topOrders,
            'sourceDataPercent' => $sourceDataPercent,
            'thisWeekData' => $thisWeekData,
            'lastWeekData' => $lastWeekData,
             'monthlyTotalOrders' => $monthlyTotalOrders,
            'monthlyPendingOrders' => $monthlyPendingOrders,
            'monthlyDeliveredOrders' => $monthlyDeliveredOrders,
            'monthlyCanceledOrders' => $monthlyCanceledOrders,
             'paymentData' => $paymentData,
            'stats' => $stats,
            'ageCategoryData' => $ageCategoryData,
            'trafficReturnData' => $trafficReturnData,
        ]);
    }

    public function conversion(Request $request)
    {
        // Récupération des filtres
        $filterDay = $request->input('day');
        $filterMonth = $request->input('month');
        $filterYear = $request->input('year');
 
        // Construction de la période à afficher
        if ($filterDay) {
            $startDate = Carbon::parse($filterDay)->startOfDay();
            $endDate = Carbon::parse($filterDay)->endOfDay();
        } elseif ($filterMonth && $filterYear) {
            $startDate = Carbon::create($filterYear, $filterMonth, 1)->startOfDay();
            $endDate = Carbon::create($filterYear, $filterMonth, 1)->endOfMonth()->endOfDay();
        } elseif ($filterYear) {
            $startDate = Carbon::create($filterYear, 1, 1)->startOfDay();
            $endDate = Carbon::create($filterYear, 12, 31)->endOfDay();
        } else {
            $startDate = now()->subDays(29)->startOfDay();
            $endDate = now()->endOfDay();
        }
 
        // Total visiteurs uniques (par IP ou autre critère)
        $totalVisitors = \App\Models\VisitorLog::whereBetween('created_at', [$startDate, $endDate])
            ->distinct('ip_address')->count('ip_address');
 
        // Total commandes (distinct par red_order)
        $totalOrders = \App\Models\Order::whereBetween('created_at', [$startDate, $endDate])
            ->distinct('red_order')->count('red_order');
 
        // Taux de conversion
        $globalConversionRate = $totalVisitors > 0 ? ($totalOrders / $totalVisitors) * 100 : 0;
 
        // Valeur moyenne commande
        $averageOrderValue = 0;
        if ($totalOrders > 0) {
            $averageOrderValue = \App\Models\Order::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('SUM(prix_produit * quantite_produit) as total')->first()->total / $totalOrders;
        }
 
        // Stats journalières sur la période filtrée
        $dailyStats = [];
        $chartLabels = [];
        $chartConversionRates = [];
 
        $period = [];
        if ($filterDay) {
            $period[] = Carbon::parse($filterDay);
        } elseif ($filterMonth && $filterYear) {
            $daysInMonth = Carbon::create($filterYear, $filterMonth, 1)->daysInMonth;
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $period[] = Carbon::create($filterYear, $filterMonth, $i);
            }
        } elseif ($filterYear) {
            for ($m = 1; $m <= 12; $m++) {
                $period[] = Carbon::create($filterYear, $m, 1);
            }
        } else {
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $period[] = $date->copy();
            }
        }
 
        foreach ($period as $date) {
            if ($filterYear && !$filterMonth && !$filterDay) {
                // Par mois (année complète)
                $start = $date->copy()->startOfMonth();
                $end = $date->copy()->endOfMonth();
                $label = $date->locale('fr_FR')->isoFormat('MMM');
            } else {
                // Par jour
                $start = $date->copy()->startOfDay();
                $end = $date->copy()->endOfDay();
                $label = $date->locale('fr_FR')->isoFormat('ddd D MMM');
            }
 
            $visitors = \App\Models\VisitorLog::whereBetween('created_at', [$start, $end])->distinct('ip_address')->count('ip_address');
            $orders = \App\Models\Order::whereBetween('created_at', [$start, $end])->distinct('red_order')->count('red_order');
            $avgValue = 0;
            if ($orders > 0) {
                $avgValue = \App\Models\Order::whereBetween('created_at', [$start, $end])->sum(DB::raw('prix_produit * quantite_produit')) / $orders;
            }
            $conversionRate = $visitors > 0 ? ($orders / $visitors) * 100 : 0;
 
            $dailyStats[] = (object)[
                'date' => $label,
                'visitors' => $visitors,
                'orders' => $orders,
                'conversion_rate' => $conversionRate,
                'average_value' => $avgValue,
            ];
            $chartLabels[] = $label;
            $chartConversionRates[] = round($conversionRate, 2);
        }
 
        // Conversion par source (exemple simple)
        $sources = \App\Models\Order::whereBetween('created_at', [$startDate, $endDate])
            ->select('source_commande')
            ->distinct()
            ->pluck('source_commande')
            ->filter(function($v) { return !is_null($v) && trim($v) !== ''; })
            ->map(function($v) { return trim($v); })
            ->values()
            ->toArray();
 
        $sourceValues = [];
        foreach ($sources as $source) {
            $sourceOrders = \App\Models\Order::where('source_commande', $source)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->distinct('red_order')->count('red_order');
            $sourceVisitors = \App\Models\VisitorLog::where('referer', $source)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->distinct('ip_address')->count('ip_address');
            // Afficher le nombre de commandes si pas de visiteurs, sinon le taux
            $sourceValues[] = $sourceVisitors > 0 ? round(($sourceOrders / $sourceVisitors) * 100, 2) : $sourceOrders;
        }
 
        $chartData = [
            'labels' => $chartLabels,
            'conversionRates' => $chartConversionRates,
            'sources' => $sources,
            'sourceValues' => $sourceValues,
        ];
 
        // Pagination
        $page = $request->input('page', 1);
        $perPage = 10;
        $dailyStatsCollection = collect($dailyStats);
        $paginatedDailyStats = new LengthAwarePaginator(
            $dailyStatsCollection->forPage($page, $perPage),
            $dailyStatsCollection->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
 
        return view('dashboard.conversion', [
            'globalConversionRate' => $globalConversionRate,
            'totalOrders' => $totalOrders,
            'totalVisitors' => $totalVisitors,
            'averageOrderValue' => $averageOrderValue,
            'dailyStats' => $paginatedDailyStats,
            'chartData' => $chartData,
        ]);
    }
}