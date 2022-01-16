<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class CustomerController extends Controller
{
    public function index() {
        // $service = new \App\Services\GenerateAvatar();

        // $avatar = $service->createAvatar(auth()->user());

        // return $avatar;

        return view('admin.customers.index', ['customers' => UserRepository::getCustomers()]);
    }

    public function update(Request $request) {

    }
}
