<?php

namespace App\Services\Factories;

use App\DataTransferObject\UserData;
use App\Services\Factories\DtoFactory;
use App\Services\AdminService;

class AdminFactory extends DtoFactory {

    protected $serviceDestination = [
        'class' => AdminService::class,
        'method' => 'create'
    ];
    
    protected function setProperties() {
        $this->properties = [
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

    public function destroy() {
        return false;
    }
}