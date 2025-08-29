<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Mobile token endpoints
Route::post('/token-login',  [AuthController::class, 'tokenLogin']);
Route::post('/token-logout', [AuthController::class, 'tokenLogout'])->middleware('auth:sanctum');

// Protected API
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
});
