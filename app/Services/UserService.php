<?php

namespace App\Services;

use App\Models\User;
use App\DataTransferObject\UserData;
use App\Expection\BusinessExpection;

class UserService {

    public function create(UserData $userData, $accountType) : User {
        if(!in_array($accountType, User::ACCOUNT_TYPES)) {
            throw new BusinessExpection("$accountType - Account Type not supported");
        }

        return User::Create([
            'name' => $userData->name,
            'email' => $userData->email,
            'password' => bcrypt($userData->password),
            'account_type' => $accountType
        ]);
    }
    
}