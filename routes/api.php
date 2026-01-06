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
use App\Http\Controllers\Api\admin\AdminCouponController;
use App\Http\Controllers\Api\admin\AdminNewController;
use App\Http\Controllers\Api\admin\AdminCategoryNewController;
use App\Http\Controllers\Api\admin\AdminAccountController;


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

        // Coupon
        Route::get('/coupons', [AdminCouponController::class, 'index']);
        Route::get('/coupon/{id}', [AdminCouponController::class, 'show']);
        Route::post('/coupon', [AdminCouponController::class, 'store']);
        Route::patch('/coupon/{id}', [AdminCouponController::class, 'update']);
        Route::delete('/coupon/{id}', [AdminCouponController::class, 'destroy']);

        // New
        Route::get('/news', [AdminNewController::class, 'index']);
        Route::get('/new/{id}', [AdminNewController::class, 'show']);
        Route::post('/new', [AdminNewController::class, 'store']);
        Route::patch('/new/{id}', [AdminNewController::class, 'update']);
        Route::delete('/new/{id}', [AdminNewController::class, 'destroy']);

        // Category New
        Route::get('/categorynews', [AdminCategoryNewController::class, 'index']);
        Route::get('/categorynew/{id}', [AdminCategoryNewController::class, 'show']);
        Route::post('/categorynew', [AdminCategoryNewController::class, 'store']);
        Route::patch('/categorynew/{id}', [AdminCategoryNewController::class, 'update']);
        Route::delete('/categorynew/{id}', [AdminCategoryNewController::class, 'destroy']);

        // Admin Account
        Route::get('/accountadmins', [AdminAccountController::class, 'index']);
        Route::get('/accountadmin/{id}', [AdminAccountController::class, 'show']);
        Route::post('/accountadmin', [AdminAccountController::class, 'store']);
        Route::patch('/accountadmin/{id}', [AdminAccountController::class, 'update']);
        Route::delete('/accountadmin/{id}', [AdminAccountController::class, 'destroy']);
    });
