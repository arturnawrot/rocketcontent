<?php

namespace Tests\Unit;

use Tests\TestCase;

class FactoryTest extends TestCase
{
    /** @test */
    public function overrides_properties()
    {
        $userFactory = $this->app->make(\App\Services\Factories\UserFactory::class);
        $userFactory->addParameters(accountType: 'CUSTOMER');
        $userFactory->override(array('name' => 'myNameIsJack'));

        $user = $userFactory->create();

        $this->assertSame($user->name, 'myNameIsJack');
    }

    /** @test */
    public function adds_parameters()
    {
        $userFactory = $this->app->make(\App\Services\Factories\UserFactory::class);
        $userFactory->addParameters(accountType: 'CUSTOMER');

        $user = $userFactory->create();

        $this->assertSame($user->account_type, 'CUSTOMER');
    }

    /** @test */
    public function overrides_the_same_parameters()
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

        $customerFactory->destroy();
    }

    /** @test */
    public function customer_has_only_one_payment_method_on_creation()
    {
        $customerFactory = $this->app->make(\App\Services\Factories\CustomerFactory::class);

        $user = $customerFactory->create();

        $this->assertSame($user->paymentMethods()->count(), 1);

        $customerFactory->destroy();
    }
}
