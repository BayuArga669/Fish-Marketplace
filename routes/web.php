<?php
// routes/web.php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FishProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// Home Route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (harus login)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Shop Management Routes
    Route::get('/shop/create', [ShopController::class, 'create'])->name('shop.create');
    Route::post('/shop/create', [ShopController::class, 'store'])->name('shop.store');
    Route::get('/shop/manage', [ShopController::class, 'manage'])->name('shop.manage');
    Route::get('/shop/edit', [ShopController::class, 'edit'])->name('shop.edit');
    Route::put('/shop/edit', [ShopController::class, 'update'])->name('shop.update');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.remove');

    // Orders (Buyer)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Checkout
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout/direct/{product}', [OrderController::class, 'directCheckout'])->name('checkout.direct');

    // Seller Routes
    Route::middleware('check.seller')->prefix('seller')->as('seller.')->group(function () {
        // Produk
        Route::get('/products/create', [FishProductController::class, 'create'])->name('products.create');
        Route::post('/products/create', [FishProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product:slug}/edit', [FishProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product:slug}/edit', [FishProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product:slug}', [FishProductController::class, 'destroy'])->name('products.destroy');

        // Pesanan (Seller Orders)
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::put('/orders/{order}/confirm', [SellerOrderController::class, 'confirm'])->name('orders.confirm');
        Route::put('/orders/{order}/reject', [SellerOrderController::class, 'reject'])->name('orders.reject');
        Route::put('/orders/{order}/process', [SellerOrderController::class, 'process'])->name('orders.process');
        Route::put('/orders/{order}/ship', [SellerOrderController::class, 'ship'])->name('orders.ship');

    });
});

// Public Routes
Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
Route::get('/shops/{shop:slug}', [ShopController::class, 'show'])->name('shops.show');
Route::get('/products', [FishProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [FishProductController::class, 'show'])->name('products.show');
