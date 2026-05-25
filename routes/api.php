<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\ProductController;

Route::apiResource('products', ProductController::class);

Route::get('/users', function () {
    return User::all();
});