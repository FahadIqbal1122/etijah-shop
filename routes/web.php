<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

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
Route::get('/checkout/success', [CheckoutController::class, 'success']);
Route::get('/checkout/failed', [CheckoutController::class, 'failed']);