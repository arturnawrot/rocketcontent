<?php

namespace App\Services\Factories;

use App\DataTransferObject\UserData;
use App\Services\Factories\DtoFactory;
use App\Services\UserService;

class UserFactory extends DtoFactory {
    protected $serviceClass = UserService::class;
    
    protected function define() {
        return new UserData(
            name: $this->faker->name(),
            email: $this->faker->email(), 
            password: $this->faker->password()
        );
    }

    protected function generateRandomParameters() {
        return Null;
    }
}