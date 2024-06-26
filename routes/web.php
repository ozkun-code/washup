<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
   return redirect()->route('login');
});

Route::middleware(['auth', 'role'])->group(function() {
    Route::get('home', \App\Livewire\Home::class)->name('home');

    Route::get('/profile', \App\Livewire\Auth\Profile::class)->name('profile');
    Route::get('/service', \App\Livewire\Service\Index::class)->name('service.index');
    Route::get('/customer', \App\Livewire\Customer\Index::class)->name('customer.index');
    Route::get('/transaksi', \App\Livewire\Transaksi\Index::class)->name('transaksi.index');
    Route::get('/voucher', \App\Livewire\Voucher\Index::class)->name('voucher.index');
    Route::get('/transaksi/create', \App\Livewire\Transaksi\Actions::class)->name('transaksi.actions');
});
Route::middleware('guest')->group(function() {  
    Route::get('/login',\App\Livewire\Auth\Login::class)->name('login');
});