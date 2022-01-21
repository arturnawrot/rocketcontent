<?php

namespace Tests\Unit;

use Tests\TestCase;

class FactoryTest extends TestCase
{
    /** @test */
    public function adds_parameters()
    {
        $userFactory = $this->app->make(\App\Services\Factories\UserFactory::class);
        $userFactory->addParameters(accountType: 'CUSTOMER');

        $user = $userFactory->create();

        $this->assertSame($user->account_type, 'CUSTOMER');
    }

    /** @test */
    public function overrides_same_parameters()
    {
        $userFactory = $this->app->make(\App\Services\Factories\UserFactory::class);
        $userFactory->addParameters(accountType: 'CUSTOMER');
        $userFactory->addParameters(accountType: 'ADMIN');

        $user = $userFactory->create();

        $this->assertSame($user->account_type, 'ADMIN');
    }

    /** @test */
    public function customer_factory_returns_user_with_customer_account_type()
    {
        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);

        $user = $customerFactory->create();

        $this->assertSame($user->account_type, 'CUSTOMER');
    }
}
