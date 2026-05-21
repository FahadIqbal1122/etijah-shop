<?php

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