<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {
    public static function getAllUsers() {
        return User::Get();
    }

    public static function getAdmins() {
        return User::Where('type', 'ADMIN')->get();
    }

    public static function getCustomers() {
        return User::Where('type', 'CUSTOMER')->get();
    }

    public static function getWriters() {
        return User::Where('type', 'WRITER')->get();
    }
}