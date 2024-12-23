<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        
        \App\Events\UserCreated::class => [
            \App\Listeners\GenerateUserAvatar::class,
        ],

        \App\Events\UserDeleting::class => [
            \App\Listeners\DeleteUserAvatar::class,
        ],

        \App\Events\PaymentMethodAdded::class => [
            \App\Listeners\UpdatePaymentMethodCache::class,
        ],

        \App\Events\DefaultPaymentMethodUpdated::class => [
            \App\Listeners\UpdatePaymentMethodCache::class,
        ],

        \App\Events\PaymentMethodDeleted::class => [
            \App\Listeners\UpdatePaymentMethodCache::class,
        ],

        \App\Events\PaymentMethodUpdated::class => [
            \App\Listeners\UpdatePaymentMethodCache::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
