<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
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
Route::post('/signup',  [AuthController::class, 'login'])->name('user.signup');


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user',  [AuthController::class, 'index']);
    Route::post('/logout',  [AuthController::class, 'logout']);
});
