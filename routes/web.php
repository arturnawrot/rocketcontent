<?php

use Illuminate\Support\Facades\Route;

// START: No authentication required area

Route::view('/', 'landing/welcome');

Route::view('/login', 'auth.login')->name('auth.login.view');

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('auth.login.request');

Route::get('/register', [App\Http\Controllers\Customer\CustomerRegisterController::class, 'show'])->name('customer.register.view');

Route::post('/register', [App\Http\Controllers\Customer\CustomerRegisterController::class, 'register'])->name('customer.register.request');

// END: No authentication required area.



// START: Auth area (any type of account)

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('auth.logout');

// END: Auth area (any type of account)



// START: Customer only area.
Route::middleware(['auth:CUSTOMER'])->group(function () {

    Route::view('/home', 'customer.dashboard')->name('customer.dashboard.view');

    Route::get('/content/new', [App\Http\Controllers\Customer\ContentRequestController::class, 'showRequestForm'])->name('customer.content.request.view');

    Route::post('/content/new', [App\Http\Controllers\Customer\ContentRequestController::class, 'submitRequest'])->name('customer.content.request.request');

});
// END: Customer only area.


// START: Admin only area.

Route::view('/admin2131sa', 'admin/home')->name('admin.home');

Route::get('/admin2131sa/customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customers.index');

// END: Admin only area.


// START: Local environment only area
Route::get('/dev/phpinfo', [App\Http\Controllers\Dev\ShowPHPInfoController::class, 'show']);
// END: Local environment only area