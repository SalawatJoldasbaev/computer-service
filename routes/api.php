<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostmanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WarehouseBasketController;
use App\Http\Controllers\WarehouseOrderController;

Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('/user')
        ->controller(UserController::class)
        ->group(function(){
            Route::post('/create', 'create');
            Route::patch('/update/{id}', 'update');
            Route::delete('/delete/{id}', 'delete');
            Route::get('/single/{id}', 'single');
            Route::get('/all', 'all');
    });

    Route::prefix('/postman')
        ->controller(PostmanController::class)
        ->group(function(){
        Route::post('/create', 'create');
        Route::get('/all', 'all_postman');
        Route::delete('/delete/{id}', 'delete');
        Route::put('update/{id}', 'update');
        Route::get('single/{id}', 'single');
    });

    Route::prefix('/category')
        ->controller(CategoryController::class)
        ->group(function(){
            Route::post('/create', 'create');
            Route::get('/categories', 'index');
            Route::patch('/update', 'update');
            Route::delete('/{id}', 'delete');
            Route::get('/{id}', 'show');
    });

    Route::prefix('/product')
        ->controller(ProductController::class)
        ->group(function(){
            Route::post('/create', 'create');
            Route::get('/all', 'all_products');
            Route::delete('/delete/{id}', 'delete');
            Route::put('/update/{id}', 'update');
            Route::get('single/{id}', 'single');
    });

    Route::prefix('/warehouse-order')
        ->controller(WarehouseOrderController::class)
        ->group(function(){
            Route::post('create', 'create');
            Route::delete('/delete/{id}', 'delete');
            Route::get('/', 'basket_orders');
    });

    Route::prefix('/warehouse-basket')
        ->controller(WarehouseBasketController::class)
        ->group(function(){
            Route::get('/all', 'all_basket');
            Route::post('/deliver', 'setWarehouse');
    });

    Route::prefix('/warehouse')
        ->controller(WarehouseController::class)
        ->group(function(){
            Route::get('/', 'index');
            Route::post('defective/products', 'defect');
    });
});

