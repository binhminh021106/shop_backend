<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Import Client
 */

use App\Http\Controllers\Api\client\ProductController;


/**
 * Import Admin
 */


/**
 * Client
 */

// Product
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'index']);

//
