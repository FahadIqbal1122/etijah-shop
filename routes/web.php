<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TapWebhookController;
use App\Http\Controllers\HubOrderController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

Route::get('/', function () {
    return view('home');
});

Route::get('/shop', function () {
    $products = \App\Models\Product::where('active', true)->orderBy('sort_order')->orderBy('name')->get();

    return view('shop.index', compact('products'));
});

Route::get('/terms', function () {
    return view('legal.terms');
});

Route::get('/privacy', function () {
    return view('legal.privacy');
});

Route::get('/checkout', [CheckoutController::class, 'show']);
Route::post('/checkout', [CheckoutController::class, 'store']);
Route::get('/checkout/success', [CheckoutController::class, 'success']);
Route::get('/checkout/failed', [CheckoutController::class, 'failed']);
Route::get('/checkout/tap/callback', [CheckoutController::class, 'tapCallback'])->name('checkout.tap.callback');
Route::post('/webhook/tap', [TapWebhookController::class, 'handle'])->name('webhook.tap');
Route::post('/api/hub/orders', [HubOrderController::class, 'store']);

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
        Route::get('/orders/{order}/invoice', [AdminOrderController::class, 'invoice'])->name('admin.orders.invoice');
        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');
        Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products');
        Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
    });
});