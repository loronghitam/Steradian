<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//
//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
//

Route::get('/cars', [CarController::class, 'get'] );
Route::get('/cars/{id}', [CarController::class, 'find'] );
Route::post('/cars', [CarController::class, 'create'] );
Route::post('/cars/{id}', [CarController::class, 'update'] );
Route::delete('/cars/{id}', [CarController::class, 'destroy'] );


Route::get('/orders', [OrderController::class, 'get'] );
Route::get('/orders/{id}', [OrderController::class, 'find'] );
Route::post('/orders', [OrderController::class, 'create'] );
Route::post('/orders/{id}', [OrderController::class, 'update'] );
Route::delete('/orders/{id}', [OrderController::class, 'destroy'] );
