<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyDriverController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DriverDocumentController;

Route::post('/login', [AuthController::class, 'login']);
// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/auth/google', [AuthController::class, 'googleLogin']);

Route::middleware('auth.api_token')->group(function () {
    // User info
    Route::get('/user', function (Request $request) {
        return $request->user()->load('documents');
    });

    // Update FCM token
    Route::put('/user/fcm-token', function (Request $request) {
        $request->validate(['fcm_token' => 'required|string']);
        $request->user()->update(['fcm_token' => $request->fcm_token]);
        return response()->json(['message' => 'FCM token updated.']);
    });

    // Update password (driver self-service)
    Route::put('/user/password', function (Request $request) {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);
        $request->user()->update(['password' => \Illuminate\Support\Facades\Hash::make($request->password)]);
        return response()->json(['message' => 'Password updated successfully.']);
    });

    // Vehicles
    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::post('/vehicles', [VehicleController::class, 'store']);
    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update']);
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy']);

    // Company Drivers
    Route::get('/drivers', [CompanyDriverController::class, 'index']);
    Route::post('/drivers', [CompanyDriverController::class, 'store']);
    Route::put('/drivers/{id}', [CompanyDriverController::class, 'update']);
    Route::delete('/drivers/{id}', [CompanyDriverController::class, 'destroy']);
    Route::post('/drivers/{id}/documents', [DriverDocumentController::class, 'store']);

    // Payments — today-status MUST come before {id} routes
    Route::get('/payments/today-status', [PaymentController::class, 'todayStatus']);
    Route::get('/payments', [PaymentController::class, 'index']);
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::post('/payments/toggle-status', [PaymentController::class, 'toggleStatus']);
    Route::put('/payments/{id}/approve', [PaymentController::class, 'approve']);
});