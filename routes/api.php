<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LiveSessionController;
use App\Http\Controllers\Api\LiveKitController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Products CRUD
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

});

// Categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Google Authentication
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Test route
Route::get('/ping', function () {
    return ['status' => 'ok'];
});

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});
Route::get('/test-delete/{id}', function ($id) {
    $product = \App\Models\Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'NOT FOUND']);
    }

    $product->delete();

    return response()->json(['message' => 'DELETED']);
});
Route::post('/live/start', [LiveSessionController::class, 'start']);
Route::post('/live/offer', [LiveSessionController::class, 'sendOffer']);
Route::put('/live/stop/{id}', [LiveSessionController::class, 'stop']);
Route::get('/live', [LiveSessionController::class, 'index']);
Route::post('/livekit/token', [LiveKitController::class, 'token']);
Route::post('/orders', [OrderController::class, 'store']);
