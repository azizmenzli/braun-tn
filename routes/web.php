<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrafficController;
use App\Http\Middleware\TrackVisitor;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentTransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Storage temporary URL route
Route::get('/storage/temporary/{path}', function ($path) {
    return Storage::disk('public')->response($path);
})->where('path', '.*')->name('storage.temporary');

// Root Site web (Frontend)
Route::get('/', function () {
    return view('index');
})->name('index')->middleware(TrackVisitor::class);

Route::get('/contact', function () { // Assuming this shows a contact form view
    return view('contact');
})->name('contact.show'); // It's good practice to name routes

Route::get('/politique-de-remboursement', function () {
    return view('politique-de-remboursement');
})->name('politique-de-remboursement')->middleware(TrackVisitor::class);

Route::get('/produit', function () { // General product listing? Consider using ProductController
    return view('produit');
})->name('produit.index'); // Example name

Route::get('/categorie', function () { // General category listing? Consider using CategoryController
    return view('categorie');
})->name('categorie.index'); // Example name


// Authentication Routes (Admin Login for Dashboard)
// This is the route that should display the login form for the dashboard
Route::get('/dashboard/login', [UserController::class, 'showLogin'])->name('login');
// This is the route that should handle the form submission
Route::post('/dashboard/login', [UserController::class, 'login']); // Laravel will match this to UserController@login on POST
Route::post('/dashboard/logout', [UserController::class, 'logout'])->name('logout');

// Password Reset Routes for Dashboard Users
Route::get('/dashboard/forgot-password', [UserController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/dashboard/forgot-password', [UserController::class, 'sendResetLinkEmail'])->name('password.email');
// Note: You'll also need routes for password reset itself (e.g., showing the reset form with token, and handling the POST to reset)

Route::get('/dashboard/reset-password/{token}', [UserController::class, 'showResetForm'])->name('password.reset'); // Route added from "updated" file
Route::post('/dashboard/reset-password', [UserController::class, 'resetPassword'])->name('password.update'); // Route added from "updated" file

// Authenticated Dashboard Routes
Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
    // Dashboard Home
    Route::get('/home', [DashboardController::class, 'index'])->name('home'); // Was named 'dashboard', changed to 'home' to avoid conflict with prefix. Access with route('dashboard.home')
    // Route::get('/profile',[UserController::class, 'showProfileDetail'])->name('profile'); // Added profile route
    // Categories
    Route::resource('categories', CategoryController::class)->names('categories'); // Access with e.g., route('dashboard.categories.index')
    Route::get('categories/{category}/subcategories', [CategoryController::class, 'getSubcategories'])->name('categories.subcategories');

    // Products Routes - Consolidated
    Route::get('produits', [ProductController::class, 'index'])->name('produits.index');
    Route::get('ajouter-produits', [ProductController::class, 'add_product'])->name('produits.add');
    Route::post('ajouter-produits', [ProductController::class, 'store'])->name('produits.store');
    Route::post('validate-sku', [ProductController::class, 'validateSku'])->name('produits.validate.sku');
    Route::get('produits/{product}/edit', [ProductController::class, 'edit'])->name('produits.edit');
    Route::put('produits/{product}', [ProductController::class, 'update'])->name('produits.update');
    Route::delete('produits/{product}', [ProductController::class, 'destroy'])->name('produits.destroy');
    Route::get('produits/{product}', [ProductController::class, 'show'])->name('produits.show');

    // Orders
    Route::get('commandes', [OrderController::class, 'index'])->name('commandes.groupedOrders');
    Route::get('detail-commande/{red_order}', [OrderController::class, 'show'])->name('commandes.show');
    Route::put('commandes/{id}/status', [OrderController::class, 'updateStatusOrder'])->name('commandes.updateStatusOrder');
    Route::post('commandes/bulk-status', [OrderController::class, 'updateBulkStatus'])->name('commandes.updateBulkStatus');
    Route::get('commandes/{red_order}/export-pdf', [OrderController::class, 'exportPdf'])->name('commandes.export.pdf');
    Route::delete('commandes/{red_order}', [OrderController::class, 'destroy'])->name('commandes.destroy');
    Route::put('commandes/{red_order}', [OrderController::class, 'update'])->name('commandes.update');

    // Clients
    Route::get('clients', [OrderController::class, 'clients'])->name('clients.index'); // Renamed from 'clients' for consistency
    Route::get('clients/{email}/commandes', [OrderController::class, 'commandesClient'])->name('clients.commandes');

    // Contact/Dealer Requests
    Route::get('contact', [ContactController::class, 'index'])->name('demandes.index');
    Route::post('demandes/update', [ContactController::class, 'update'])->name('demandes.update');
    Route::delete('demandes/{id}', [ContactController::class, 'destroy'])->name('demandes.destroy');

    // Users Management
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('profile', [UserController::class, 'showProfileDetail'])->name('profile');
    Route::post('profile/password', [UserController::class, 'updatePassword'])->name('profile.password');

    // Traffic
    Route::get('traffic', [TrafficController::class, 'index'])->name('traffic');

    // Route pour la page de conversion (accepte les filtres GET : day, month, year)
    Route::get('conversion', [DashboardController::class, 'conversion'])->name('conversion');

    // Fallback for potentially removed specific anonymous routes if they were meant for dashboard
    // For example, if 'dashboard/produits' was an anonymous function before, it's now covered by ProductController.
    // Ensure all necessary views like 'dashboard/transaction', 'dashboard/commandes' are handled by controllers or are static views not needing specific routes if covered by broader controllers.

    // Routes du dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::resource('orders', OrderController::class);
    Route::resource('transactions', PaymentTransactionController::class);

    // Route pour les logs des visiteurs et des commandes
    Route::get('/logs', [OrderController::class, 'orderVisitorLogs'])->name('dashboard.order-visitor-logs');

    // Transactions Routes
    Route::get('transactions', [PaymentTransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/{transaction}', [PaymentTransactionController::class, 'show'])->name('transactions.show');
    Route::get('transactions/{transaction}/export-pdf', [PaymentTransactionController::class, 'exportPdf'])->name('transactions.export.pdf');
    Route::put('transactions/{transaction}/status', [PaymentTransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
});


// Frontend Product and Category Display
Route::get('/produit/{id}', [ProductController::class, 'show'])->name('product.detail')->middleware(TrackVisitor::class);
Route::get('/categorie/{categoryId}', [ProductController::class, 'showCategoryAndSubCategoryProducts'])->name('category.show')->middleware(TrackVisitor::class);

// Cart
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');

// Checkout Process
Route::prefix('checkout')->name('checkout.')->group(function () {
    // Afficher la page de checkout
    Route::get('/', [OrderController::class, 'checkout'])
        ->name('checkout');
          // Middleware optionnel pour vérifier que le panier n'est pas vide
 
    // Traiter la commande
    Route::post('/process', [OrderController::class, 'processOrder'])
        ->name('process');
 
    // Page de confirmation
    Route::get('/confirmation/{redOrder}', [OrderController::class, 'showOrderConfirmation'])
        ->name('confirmation');
});
 

// API for stock check (example)
Route::get('/api/check-stock/{productId}', [OrderController::class, 'checkStock'])->name('api.check.stock');

// Contact form submission (Frontend - Devenir Revendeur)
Route::post('/contact', [ContactController::class, 'store'])->name('devenir-revendeur.store')->middleware(TrackVisitor::class);

Route::get('transaction', function () {
    return view('dashboard/transaction');
})->name('transaction');

// Cleanup of old/potentially conflicting standalone dashboard routes (ensure these are now handled within the 'auth' group or are intentionally public)

/*
Route::get('dashboard/home', function () { // This was conflicting, now handled by DashboardController inside auth group
    return view('dashboard/index')->name('dashboard.home');
});


/* // These seemed to be public or misplaced dashboard routes. Ensure their functionality is covered within the auth group or defined intentionally if public.
Route::get('produits', function () { // This path is '/' + 'produits'. If meant for dashboard, should be /dashboard/produits
    return view('dashboard/produits');
});

Route::middleware(['auth'])->group(function () {
    Route::get('categories', function () { // This path is '/' + 'categories'. If meant for dashboard, should be /dashboard/categories
        return view('dashboard/categories');
    });
});
Route::get('dashboard/commandes', function () { // Now handled by OrderController inside auth group
    return view('dashboard/commandes');
})->name('dashboard.commandes'); // Name would conflict if not removed

Route::get('transaction', function () { // This path is '/' + 'transaction'. If meant for dashboard, should be /dashboard/transaction
    return view('dashboard/transaction');
})->name('transaction');
*/

// Route pour rafraîchir le token CSRF
Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});

// Consolidated Payment Routes
Route::get('/payment-success', function () {
    return view('payment.success', ['payment_ref' => request('payment_ref')]);
})->name('payment.success');
 
Route::get('/payment-fail', function () {
    return view('payment.fail');
})->name('payment.fail'); 





?>