<?php

use App\Http\Controllers\App\Auth\AuthenticationAppController;
use App\Http\Controllers\App\Notifications\AppNotificationController;
use App\Http\Controllers\Dashboard\Accounts\CostumerAccountController;
use App\Http\Controllers\Dashboard\Accounts\EmployeeAccountController;
use App\Http\Controllers\Dashboard\Auth\DashboardAuthController;
use App\Http\Controllers\Dashboard\Transactions\EmployeeCashTransactionController;
use App\Http\Controllers\Dashboard\Transactions\TransactionApprovalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AppNotificationController::class)
    ->middleware('auth:sanctum')
    ->group(function(){
        Route::post('/deviceToken', 'registerDeviceToken');
        Route::post('/mark_as_read/{notificationId}', 'mark_as_read');
    });

Route::prefix('app')->group(function () {

Route::prefix('auth')->group(function () {
    Route::post('activate-account', [AuthenticationAppController::class, 'activateAccount']);
    Route::post('reset-password', [AuthenticationAppController::class, 'resetPassword']);
    Route::post('login', [AuthenticationAppController::class, 'login']);

    Route::middleware('auth:sanctum')->delete('logout', [AuthenticationAppController::class, 'logout']);

    });
    Route::middleware(['auth:sanctum'])
        ->controller(EmployeeCashTransactionController::class)
        ->prefix('/cash')
        ->group(function () {

            Route::post('transfer', 'transfer');
        });
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


    Route::middleware(['auth:sanctum'])
        ->controller(EmployeeCashTransactionController::class)
        ->prefix('/cash')
        ->group(function () {
            Route::post('deposit','deposit');
            Route::post('withdraw', 'withdraw');
            Route::post('transfer', 'transfer');
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
    Route::post('approve-transaction/{transactionId}', [TransactionApprovalController::class, 'approve'])
        ->middleware('auth:sanctum');

});
