<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('meals')->group(function (){
    Route::get('/', [MealController::class, 'index']);
    Route::post('/', [MealController::class, 'store']);
    Route::put('/', [MealController::class, 'update']);
    Route::get('/{id}', [MealController::class, 'show']);
    Route::delete('/{id}', [MealController::class, 'destroy']);
});

Route::prefix('users')->group(function (){
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('/', [UserController::class, 'update']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::prefix('orders')->group(function (){
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::put('/', [OrderController::class, 'update']);
    Route::get('/{id}', [OrderController::class, 'show']);
    Route::delete('/{id}', [OrderController::class, 'destroy']);
});

Route::resource('purchases', PurchaseController::class);

