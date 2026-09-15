<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () { return response()->json(['message' => 'API is running']); });

Route::get('/privacy-policy', function () {
    return view('privacy');
})->name('privacy-policy');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
