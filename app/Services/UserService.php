<?php

namespace App\Services;

use App\Services\Contracts\AbstractEntityService;
use App\DataTransferObject\UserData;
use App\Expections\BusinessExpection;
use App\Events\UserCreated;
use App\Events\UserDeleting;
use App\Models\User;

class UserService extends AbstractEntityService {

    public function create(UserData $userData, string $accountType) : User {
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