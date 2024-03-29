<?php

use Illuminate\Support\Facades\Route;

// START: No authentication required area

Route::view('/', 'landing/welcome');

Route::middleware(['guest'])->group(function () {

    Route::view('/login', 'auth.login')->name('login');

    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('auth.login.request');

    Route::get('/register', [App\Http\Controllers\Customer\CustomerRegisterController::class, 'show'])->name('customer.register.view');

    Route::post('/register', [App\Http\Controllers\Customer\CustomerRegisterController::class, 'register'])->name('customer.register.request');

});


// END: No authentication required area.



// START: Auth area (any type of account)

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('auth.logout');

// END: Auth area (any type of account)



// START: Customer only area.
Route::middleware(['auth:CUSTOMER'])->group(function () {

    Route::get('/home', [App\Http\Controllers\Customer\HomeController::class, 'dashboard'])->name('customer.dashboard.view');

    Route::get('/content/new', [App\Http\Controllers\Customer\ContentRequestController::class, 'showRequestForm'])->name('customer.content.request.view');

    Route::post('/content/new', [App\Http\Controllers\Customer\ContentRequestController::class, 'submitRequest'])->name('customer.content.request.request');

    Route::post('/payment-method/add', [App\Http\Controllers\Customer\PaymentMethodController::class, 'addPaymentMethod'])->name('customer.payment-method.add');

    Route::post('/payment-method/setDefault', [App\Http\Controllers\Customer\PaymentMethodController::class, 'setDefaultPaymentMethod'])->name('customer.payment-method.set-default');

    Route::post('/payment-method/delete', [App\Http\Controllers\Customer\PaymentMethodController::class, 'deletePaymentMethod'])->name('customer.payment-method.delete');

    Route::patch('/payment-method/update', [App\Http\Controllers\Customer\PaymentMethodController::class, 'updatePaymentMethod'])->name('customer.payment-method.update');

    Route::post('/subscription/cancel', [App\Http\Controllers\Customer\SubscriptionController::class, 'cancel'])->name('customer.subscription.cancel');

});
// END: Customer only area.


// START: Admin only area.
Route::middleware(['auth:ADMIN'])->group(function () {
    Route::view('/admin2131sa', 'admin/home')->name('admin.dashboard.view');

    Route::get('/admin2131sa/customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customers.index');
});
// END: Admin only area.


// START: Local environment only area
Route::get('/dev/phpinfo', [App\Http\Controllers\Dev\ShowPHPInfoController::class, 'show']);
// END: Local environment only area

// START: API
Route::get('/api/getIntentToken', [App\Http\Controllers\Api\GenerateStripeIntentController::class, 'generateIntentToken'])->name('api.customer.intentToken.get');
// END: API