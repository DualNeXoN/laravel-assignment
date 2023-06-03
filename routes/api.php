<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PartController;

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

Route::get('/cars', [CarController::class, 'index']);
Route::post('/cars/add', [CarController::class, 'store']);
Route::put('/cars/{id}', [CarController::class, 'update']);
Route::delete('/cars/{id}', [CarController::class, 'destroy']);
Route::get('/cars/{car}/parts', [CarController::class, 'getCarParts']);
Route::delete('/cars/{carId}/parts/{partId}/remove', [CarController::class, 'removePartFromCar']);
Route::post('/cars/{carId}/parts/{partId}/add', [CarController::class, 'addPartToCar']);
Route::get('/parts', [PartController::class, 'index']);
Route::get('/parts/{id}', [PartController::class, 'show']);
Route::delete('/parts/{id}', [PartController::class, 'destroy']);
Route::post('/parts/add', [PartController::class, 'store']);
Route::put('/parts/{id}', [PartController::class, 'update']);