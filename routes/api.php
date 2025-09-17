<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('profile', [AuthController::class, 'me'])->middleware('auth:api');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::post('movie', [MovieController::class, 'store'])->middleware('auth:api');
Route::get('movie', [MovieController::class, 'show'])->middleware('auth:api');
Route::get('movie/{movie}', [MovieController::class, 'index'])->middleware('auth:api');
Route::put('movie/{movie}', [MovieController::class, 'update'])->middleware('auth:api');
Route::delete('movie/{movie}', [MovieController::class, 'destroy'])->middleware('auth:api');

// Route::apiResource('movie', MovieController::class);