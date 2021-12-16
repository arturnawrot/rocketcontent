<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class CustomerController extends Controller
{
    public function index() {
        return view('admin.customers.index', ['customers' => UserRepository::getCustomers()]);
    }

    public function update(Request $request) {

    }
}
