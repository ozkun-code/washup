<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ResiController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/vouchers', [VoucherController::class, 'getAll']); 

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/transaksi/completed/{customerId}', [TransaksiController::class, 'getCompletedTransactions']);
    Route::get('/transaksi/ongoing/{customerId}', [TransaksiController::class, 'getOngoingTransactions']);
    Route::get('/transaksi/detail/{id}', [TransaksiController::class, 'getTransaksiById']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/services', [ServiceController::class, 'getAllServices']);
    Route::get('/customer', [CustomerController::class, 'getCustomer']);
    Route::put('/customer', [CustomerController::class, 'update']);
    Route::get('/transaksi/{customerId}', [TransaksiController::class, 'getTransaksiByCustomerId']);
    Route::get('/resi/{transaksiId}', [ResiController::class, 'getResi']);
    Route::post('/claim-voucher/{voucher}', [VoucherController::class, 'claim']);
    Route::get('/claimed-vouchers', [VoucherController::class, 'getClaimedVouchers']);
});
