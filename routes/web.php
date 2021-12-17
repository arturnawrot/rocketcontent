<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'landing/welcome');

Route::view('/login', 'auth.login');

Route::get('/register', [App\Http\Controllers\Customer\CustomerRegisterController::class, 'show'])->name('customer-register.show');

Route::post('/register', [App\Http\Controllers\Customer\CustomerRegisterController::class, 'register'])->name('customer-register.register');

Route::get('/dev/phpinfo', [App\Http\Controllers\Dev\ShowPHPInfoController::class, 'show']);


Route::view('/admin2131sa', 'admin/home')->name('admin.home');

Route::get('/admin2131sa/customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customers.index');