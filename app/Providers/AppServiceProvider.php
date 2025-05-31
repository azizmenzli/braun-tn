<?php
 
namespace App\Providers;
 
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use App\Models\Demande_revendeur;
use App\Http\Controllers\ProductController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
 
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }
 
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            // Force HTTPS for all URLs
            URL::forceScheme('https');
            URL::forceRootUrl('https://braun.tn');
            
            // Ensure all redirects use HTTPS
            if (request()->secure()) {
                URL::forceScheme('https');
            }
           
            // Force HTTPS for storage URLs
            Storage::disk('public')->buildTemporaryUrlsUsing(function ($path, $expiration, $options) {
                return 'https://braun.tn/storage/' . $path;
            });
        }
 
        view()->composer('*', function ($view) {
            $now = Carbon::now();
            $last24Hours = $now->copy()->subDay();
 
            $ordersGroupedByRedOrder = Order::select(
                    'orders.red_order',
                    DB::raw('COUNT(DISTINCT orders.red_order) as count'),
                    DB::raw('SUM(orders.quantite_produit) as products_count')
                )
                ->join('products', 'orders.id_produit', '=', 'products.id')
                ->where('orders.created_at', '>=', $last24Hours)
                ->where('orders.status', '=', 'encours')
                ->groupBy('orders.red_order')
                ->get();
 
            $messagesCount = Demande_revendeur::where('created_at', '>=', $last24Hours)->count();
 
            $view->with([
                'ordersGroupedByRedOrder' => $ordersGroupedByRedOrder,
                'messagesCount' => $messagesCount,
            ]);
        });
 
        View::composer('dashboard.components.header', function ($view) {
            $stockNotifications = ProductController::getNotifications();
            $view->with('stockNotifications', $stockNotifications);
        });
    }
}