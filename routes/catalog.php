<?php

use App\Http\Controllers\Catalog\CategoryController;
use App\Http\Controllers\Catalog\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);


Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);

