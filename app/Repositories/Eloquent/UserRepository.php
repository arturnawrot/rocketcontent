<?php

namespace App\Repositories\Eloquent;

use App\Models\User;

class UserRepository {
    public static function getAllUsers() {
        return User::Get();
    }

    public static function getAdmins() {
        return User::Where('account_type', 'ADMIN')->get();
    }

    public static function getCustomers() {
        return User::Where('account_type', 'CUSTOMER')->get();
    }

    public static function getWriters() {
        return User::Where('account_type', 'WRITER')->get();
    }
}