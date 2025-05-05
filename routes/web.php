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

// Public Routes
Route::middleware([TrackVisitor::class])->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('index');

    Route::get('/politique-de-remboursement', function () {
        return view('politique-de-remboursement');
    })->name('politique-de-remboursement');

    Route::get('/produit/{id}', [ProductController::class, 'show'])->name('product.detail');
    Route::get('/categorie/{categoryId}', [ProductController::class, 'showCategoryAndSubCategoryProducts'])->name('category.show');
});

// Public routes without visitor tracking
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/produit', function () {
    return view('produit');
})->name('produit');

Route::get('/categorie', function () {
    return view('categorie');
})->name('categorie');

// Cart Routes
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

// Checkout Routes
Route::prefix('checkout')->group(function () {
    Route::get('/', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/process', [OrderController::class, 'processOrder'])->name('checkout.process');
    Route::get('/confirmation/{redOrder}', [OrderController::class, 'showOrderConfirmation'])->name('checkout.confirmation');
});

// Contact Routes
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/contact', [ContactController::class, 'index'])->name('dashboard.contact.index');
    Route::post('/demandes/update', [ContactController::class, 'update'])->name('dashboard.contact.update');
    Route::delete('/demandes/{id}', [ContactController::class, 'destroy'])->name('dashboard.contact.destroy');
});

// Authentication Routes
Route::prefix('dashboard')->group(function () {
    Route::get('/', [UserController::class, 'showLogin'])->name('login');
    Route::post('/', [UserController::class, 'login'])->name('login.submit');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    
    // Password Reset Routes
    Route::get('/forgot-password', [UserController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [UserController::class, 'sendResetLink'])->name('password.email');
});

// Protected Dashboard Routes
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    // Dashboard Home
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard.home');

    // Categories
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'dashboard.categories.index',
        'create' => 'dashboard.categories.create',
        'store' => 'dashboard.categories.store',
        'edit' => 'dashboard.categories.edit',
        'update' => 'dashboard.categories.update',
        'destroy' => 'dashboard.categories.destroy'
    ]);
    Route::get('/categories/{category}/subcategories', [CategoryController::class, 'getSubcategories'])
        ->name('dashboard.categories.subcategories');

    // Products
    Route::resource('produits', ProductController::class)->names([
        'index' => 'dashboard.produits.index',
        'create' => 'dashboard.produits.create',
        'store' => 'dashboard.produits.store',
        'edit' => 'dashboard.produits.edit',
        'update' => 'dashboard.produits.update',
        'destroy' => 'dashboard.produits.destroy'
    ]);
    Route::post('/validate-sku', [ProductController::class, 'validateSku'])->name('dashboard.validate.sku');

    // Orders
    Route::get('/commandes', [OrderController::class, 'index'])->name('dashboard.orders.index');
    Route::get('/commandes/{red_order}', [OrderController::class, 'show'])->name('dashboard.orders.show');
    Route::put('/commandes/{id}/status', [OrderController::class, 'updateStatusOrder'])->name('dashboard.orders.update-status');

    // Clients
    Route::get('/clients', [OrderController::class, 'clients'])->name('dashboard.clients.index');
    Route::get('/clients/{email}/commandes', [OrderController::class, 'commandesClient'])->name('dashboard.clients.orders');

    // Users
    Route::resource('users', UserController::class)->names([
        'index' => 'dashboard.users.index',
        'store' => 'dashboard.users.store',
        'update' => 'dashboard.users.update',
        'destroy' => 'dashboard.users.destroy'
    ]);

    // Traffic
    Route::get('/traffic', [TrafficController::class, 'index'])->name('dashboard.traffic.index');
});