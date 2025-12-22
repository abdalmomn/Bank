<?php

use App\Http\Controllers\App\Auth\AuthenticationAppController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('app/auth')->group(function () {
    Route::post('activate-account', [AuthenticationAppController::class, 'activateAccount']);
    Route::post('reset-password', [AuthenticationAppController::class, 'resetPassword']);
    Route::post('login', [AuthenticationAppController::class, 'login']);

    Route::middleware('auth:sanctum')->delete('logout', [AuthenticationAppController::class, 'logout']);
});
