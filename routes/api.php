<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController; 
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('tags', TagController::class);
});

Route::get('/users', function () {
    return User::all();
});