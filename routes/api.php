<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;

Route::post('/tokens/create', [TokenController::class, 'create']);

Route::apiResource('users', UserController::class)->middleware(['auth:sanctum']);
