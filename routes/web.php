<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dev\ShowPHPInfoController;

Route::view('/', 'welcome');

Route::get('/dev/phpinfo', [ShowPHPInfoController::class, 'show']);
