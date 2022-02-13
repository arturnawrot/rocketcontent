<?php

namespace App\Services\Factories;

use App\DataTransferObject\UserData;
use App\Services\Factories\DtoFactory;
use App\Services\UserService;

class UserFactory extends DtoFactory {

    protected $serviceDestination = [
        'class' => UserService::class,
        'method' => 'create'
    ];
    
    protected function getProperties() {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(), 
            'password' => $this->faker->password()
        ];
    }

    protected function define() {
        return new UserData(
            name: $this->properties['name'],
            email: $this->properties['email'], 
            password: $this->properties['password']
        );
    }
}