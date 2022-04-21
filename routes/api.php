<?php

use App\Http\Controllers\AccountingOrderReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\PostmanController;
use App\Http\Controllers\ProductController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\HistoryOrderController;
use App\Http\Controllers\AccountNumberController;
use App\Http\Controllers\WarehouseOrderController;
use App\Http\Controllers\WarehouseBasketController;
use App\Http\Controllers\WarehouseDefectController;

Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('/user')
        ->controller(UserController::class)
        ->group(function () {
            Route::post('/create', 'create');
            Route::patch('/update/{id}', 'update');
            Route::delete('/delete/{id}', 'delete');
            Route::get('/single/{id}', 'single');
            Route::get('/all', 'all');
        });
    Route::get('/postman/{id}/payment/history', [AccountNumberController::class, 'index']);
    Route::patch('/postman/{id}/payment/history/update', [AccountNumberController::class, 'update']);
    Route::prefix('/postman')
        ->controller(PostmanController::class)
        ->group(function () {
            Route::post('/create', 'create');
            Route::get('/all', 'all_postman');
            Route::delete('/delete/{id}', 'delete');
            Route::put('update/{id}', 'update');
            Route::get('single/{id}', 'single');
        });

    Route::prefix('/category')
        ->controller(CategoryController::class)
        ->group(function () {
            Route::post('/create', 'create');
            Route::get('/categories', 'index');
            Route::patch('/update', 'update');
            Route::delete('/{id}', 'delete');
            Route::get('/{id}', 'show');
        });

    Route::prefix('/product')
        ->controller(ProductController::class)
        ->group(function () {
            Route::post('/create', 'create');
            Route::get('/all', 'all_products');
            Route::delete('/delete/{id}', 'delete');
            Route::put('/update/{id}', 'update');
            Route::get('single/{id}', 'single');
        });

    Route::prefix('/warehouse-order')
        ->controller(WarehouseOrderController::class)
        ->group(function () {
            Route::post('create', 'create');
            Route::delete('/delete/{id}', 'delete');
            Route::get('/', 'basket_orders');
        });
    Route::get('/warehouse/baskets/accounting/', [AccountingOrderReviewController::class, 'baskets']);
    Route::prefix('/warehouse-basket')
        ->controller(WarehouseBasketController::class)
        ->group(function () {
            Route::get('/all', 'all_basket');
            Route::post('/deliver', 'setWarehouse');
        });
    Route::get('/orders/history', [HistoryOrderController::class, 'index']);
    Route::get('/orders/history/{basket_id}', [HistoryOrderController::class, 'orders']);
    Route::prefix('/warehouse')
        ->controller(WarehouseController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::post('defective/products', 'defect');
        });
    Route::get('/warehouse/costprice', [WarehouseController::class, 'cost_price']);
    Route::get('/code/{code}', [QrCodeController::class, 'code']);

    Route::post('/defect/set-item', [WarehouseDefectController::class, 'setBasket']);
    Route::get('/defect/get-items', [WarehouseDefectController::class, 'getBasketItems']);
    Route::delete('/defect/items/delete', [WarehouseDefectController::class, 'deleteItem']);
    Route::patch('/defect/item/update', [WarehouseDefectController::class, 'updateItem']);
    Route::post('/defect/confirm', [WarehouseDefectController::class, 'confirm']);
    Route::get('/defect/history', [WarehouseDefectController::class, 'index']);
});
Route::get('/code/', [QrCodeController::class, 'generate']);
Route::get('/qr/{text}', function ($text) {
    return QrCode::size(250)->generate('https://salawat.me');
});
