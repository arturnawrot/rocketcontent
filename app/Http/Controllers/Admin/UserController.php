<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    public function index() {
        return view('admin.users.index', ['users' => UserRepository::getAllUsers()]);
    }
}
