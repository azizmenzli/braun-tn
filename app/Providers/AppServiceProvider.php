<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order;
    use App\Models\Demande_revendeur;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    
  
    public function boot()
    {
        // Partager les notifications globalement pour toutes les vues
        view()->composer('*', function ($view) {
            // Utilisation de Carbon pour obtenir les commandes des dernières 24 heures
            $now = Carbon::now();
            $last24Hours = $now->subDay();
    
            // Groupement des commandes par red_order et comptage
            $ordersGroupedByRedOrder = Order::select('orders.red_order', 
            DB::raw('COUNT(DISTINCT orders.red_order) as count'), // Compte distinctement les red_order
            DB::raw('SUM(orders.quantite_produit) as products_count') // Somme des quantités de produits
        )
        ->join('products', 'orders.id_produit', '=', 'products.id') // Jointure avec la table products
        ->where('orders.created_at', '>=', $last24Hours)
        ->where('orders.status', '=', 'encours')  // Filtre sur le statut 'encours'
        ->groupBy('orders.red_order')
        ->get();

        
    
            // Compter les messages reçus dans les dernières 24 heures
            $messagesCount = Demande_revendeur::where('created_at', '>=', $last24Hours)->count();
    
            // Partager les données avec toutes les vues
            $view->with([
                'ordersGroupedByRedOrder' => $ordersGroupedByRedOrder,
                'messagesCount' => $messagesCount,
            ]);
        });
    }
    
    
        public function register()
        {
            //
        }
    }
    

 