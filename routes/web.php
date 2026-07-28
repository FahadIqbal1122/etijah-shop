<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TapWebhookController;
use App\Http\Controllers\HubOrderController;

Route::get('/', function () {
    return view('home');
});

Route::get('/shop', function () {
    return view('shop.index');
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