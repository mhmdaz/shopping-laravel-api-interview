<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::post('/tokens/create', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $token = $request->user()->createToken($request->token_name ?? 'token', [$request->user()->role]);

        return ['token' => $token->plainTextToken];
    }

    return [];
});

Route::apiResource('users', UserController::class)->middleware(['auth:sanctum']);
