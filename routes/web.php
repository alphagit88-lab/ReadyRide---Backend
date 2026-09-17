<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\UserManagementController;

Route::get('/', function () { return response()->json(['message' => 'API is running']); });

Route::get('/privacy-policy', function () {
    return view('privacy');
})->name('privacy-policy');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// ── Admin Panel ───────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login',  [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.post');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('users/companies-json', [UserManagementController::class, 'companiesJson'])->name('users.companies-json');
        Route::resource('users', UserManagementController::class)->except(['show']);
    });
});
