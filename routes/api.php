<?php

use Illuminate\Support\Facades\Route;

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


Route::middleware('auth:sanctum')->post('/caliber', [\App\Http\Controllers\API\V1\CounterController::class, 'caliber']);
Route::middleware('auth:sanctum')->post('/getInn', [\App\Http\Controllers\API\V1\CounterController::class, 'getInn']);
