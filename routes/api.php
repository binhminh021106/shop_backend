<?php

use Illuminate\Http\Request;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Route;


/**
 * Import Client
 */

use App\Http\Controllers\Api\client\ProductController;
use App\Http\Controllers\Api\client\VariantController;


/**
 * Import Admin
 */

use App\Http\Controllers\Api\admin\AdminProductController;
use App\Http\Controllers\Api\admin\AdminCategoryController;
use App\Http\Controllers\Api\admin\AdminBrandController;

/**
 * Client
 */

// Product
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);

// Variant
Route::get('/variants', [VariantController::class, 'index']);
Route::get('/variant/{id}', [VariantController::class, 'show']);

/**
 * Admin
 */
Route::middleware(['auth:sanctum', CheckAdmin::class])
    ->prefix('admin')
    ->group(function () {

        // Product
        Route::get('/products', [AdminProductController::class, 'index']);
        Route::get('/product/{id}', [AdminProductController::class, 'show']);

        // Category
        Route::get('/categories', [AdminCategoryController::class, 'index']);
        Route::get('/category/{id}', [AdminCategoryController::class, 'show']);
        Route::post('/category', [AdminCategoryController::class, 'store']);
        Route::patch('/category/{id}', [AdminCategoryController::class, 'update']);
        Route::delete('/category/{id}', [AdminCategoryController::class, 'destroy']);

        // Brand
        Route::get('/brands', [AdminBrandController::class, 'index']);
        Route::get('/brand/{id}', [AdminBrandController::class, 'show']);
        Route::post('/brand', [AdminBrandController::class, 'store']);
        Route::patch('/brand/{id}', [AdminBrandController::class, 'update']);
        Route::delete('/brand/{id}', [AdminBrandController::class, 'destroy']);
    });
