<?php

use App\Http\Controllers\App\Auth\AuthenticationAppController;
use App\Http\Controllers\Dashboard\Accounts\CostumerAccountController;
use App\Http\Controllers\Dashboard\Accounts\EmployeeAccountController;
use App\Http\Controllers\Dashboard\Auth\DashboardAuthController;
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


Route::prefix('dashboard/employee')->group(function(){
    Route::post('login', [DashboardAuthController::class, 'login']);
    Route::middleware('auth:sanctum')->delete('logout', [DashboardAuthController::class, 'logout']);


    Route::controller(CostumerAccountController::class)->middleware('auth:sanctum')->group(function(){

    Route::post('create-customer', 'store');
// إنشاء عميل جديد
    Route::post('/customers','store');

// عرض جميع العملاء
    Route::get('/customers', 'index');

// عرض تفاصيل عميل محدد
    Route::get('/customers/{userId}', 'show');

// تحديث بيانات عميل
    Route::post('/customers/{userId}','update');

// حذف عميل
    Route::delete('/customers/{userId}','destroy');

    });
});





/**
 * Admin
*/
Route::prefix('dashboard/admin')->group(function(){
    Route::post('login', [DashboardAuthController::class, 'login']);
    Route::middleware('auth:sanctum')->delete('logout', [DashboardAuthController::class, 'logout']);

    Route::controller(EmployeeAccountController::class)->middleware('auth:sanctum')->group(function() {

        Route::post('create-employee', 'store');

        Route::get('/employees','index');

        Route::get('/employees/{userId}', 'show');

        Route::post('/employees/{userId}',  'update');

        Route::delete('/employees/{userId}', 'destroy');
    });
});
