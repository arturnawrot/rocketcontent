<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class HomeController extends Controller {

    public function dashboard()
    {
        return view('customer.dashboard', ['user' => auth()->user()]);
    }
    
}