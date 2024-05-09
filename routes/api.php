<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// PUBLIC APIs

Route::post('/login',  [AuthController::class, 'login'])->name('user.login');
Route::post('/signup',  [AuthController::class, 'signup'])->name('user.signup');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthController::class, 'show']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        Route::prefix('brand')->controller(BrandController::class)->group(function () {
            Route::get('/',                'index');
            Route::post('/',               'store');
            Route::put('/{id}',            'update');
            Route::delete('/{id}',         'destroy');
        });
        Route::prefix('product')->controller(ProductController::class)->group(function () {
            Route::get('/',                'index');
            Route::post('/',               'store')->name('product.create');
            Route::put('/{id}',            'update')->name('product.update');
            Route::delete('/{id}',         'destroy');
        });
    });

    Route::prefix('supplier')->middleware(['role:supplier'])->group(function () {
        Route::prefix('product')->controller(ProductController::class)->group(function () {
            Route::get('/',                'index');
            Route::post('/',               'store')->name('product.create');
            Route::put('/{id}',            'update')->name('product.update');
            Route::delete('/{id}',         'destroy');
        });
        Route::prefix('inventory')->controller(InventoryController::class)->group(function () {
            Route::get('/',                'index');
        });
    });

    Route::prefix('store')->middleware(['role:store'])->group(function () {
        Route::prefix('brand')->controller(BrandController::class)->group(function () {
            Route::get('/',                'index');
            Route::post('/',               'store');
            Route::put('/{id}',            'update');
            Route::delete('/{id}',         'destroy');
        });
        Route::prefix('inventory')->controller(InventoryController::class)->group(function () {
            Route::get('/',                'index');
            Route::post('/',               'store');
            Route::delete('/{id}',         'destroy')->name('inventory.destroy');
        });
    });
    Route::prefix('customer')->middleware(['role:customer'])->group(function () {
        Route::prefix('cart')->controller(CartController::class)->group(function () {
            Route::get('/',                'index');
            Route::post('/',               'store');
            Route::delete('/{id}',         'destroy')->name('cart.destroy');
        });
        Route::prefix('order')->controller(OrderController::class)->group(function () {
            Route::get('/',                'index');
            Route::post('/',               'index');
            Route::delete('/{id}',         'destroy');
        });
    });
});
