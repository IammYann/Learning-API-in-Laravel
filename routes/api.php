<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::apiResource('products', ProductController::class);
Route::apiResource('categories', CategoryController::class);

Route::get('/users', function () {
    return User::all();
});