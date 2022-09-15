<?php

namespace App\Services;

use App\Models\User;
use App\DataTransferObject\UserData;

class AdminService {
    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function create(UserData $userData) : User {
        return $this->userService->create($userData, 'ADMIN');
    }
}