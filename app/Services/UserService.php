<?php

namespace App\Services;

use App\Models\User;
use App\DataTransferObject\UserData;
use App\Expection\BusinessExpection;
use App\Events\UserCreated;
use App\Events\UserDeleting;

class UserService {

    public function create(UserData $userData, $accountType) : User {
        if(!in_array($accountType, User::ACCOUNT_TYPES)) {
            throw new BusinessExpection("$accountType - Account Type not supported");
        }

        $user = User::Create([
            'name' => $userData->name,
            'email' => $userData->email,
            'password' => bcrypt($userData->password),
            'account_type' => $accountType
        ]);
        
        UserCreated::dispatch($user);

        return $user;
    }

    public function delete(User $user) {
        UserDeleting::dispatch($user);

        $user->delete();
    }
    
}