<?php
// routes/web.php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FishProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

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
    
    // Product Management Routes (khusus seller)
    Route::middleware('check.seller')->group(function () {
        Route::get('/products/create', [FishProductController::class, 'create'])->name('products.create');
        Route::post('/products/create', [FishProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product:slug}/edit', [FishProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product:slug}/edit', [FishProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product:slug}', [FishProductController::class, 'destroy'])->name('products.destroy');
    });
});

// Public Routes (didefinisikan terakhir biar tidak bentrok dengan create/edit)
Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
Route::get('/shops/{shop:slug}', [ShopController::class, 'show'])->name('shops.show');
Route::get('/products', [FishProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [FishProductController::class, 'show'])->name('products.show');
