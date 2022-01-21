<?php

namespace App\Services\Factories;

class CustomerFactory extends UserFactory {
    public function __construct() 
    {
        parent::__construct();

        $this->addParameters(accountType: 'CUSTOMER');
    }
}