<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
     
Route::middleware('auth:api')->group( function () {
    
    Route::get('logout', [AuthController::class, 'logout']);

    Route::get('users', [UserController::class, 'index']);
    Route::post('users/create', [UserController::class, 'store']);
    Route::put('users/update/{id}', [UserController::class, 'update']);
    Route::delete('users/delete/{id}', [UserController::class, 'destroy']);
});