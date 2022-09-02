<?php

namespace App\Providers;

use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\ServiceProvider;
use Stripe\StripeClient;
use Laravel\Cashier\Http\Middleware\VerifyWebhookSignature;
use App\Helpers\PHPUnit;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $isRunningTests = PHPUnit::isPHPUnitProcessRunning();

        // dd($isRunningTests);

        if ($isRunningTests and !($this->app->environment('production'))) {
            
            $isRequestFromStripe = request()->header('user-agent') == 'Stripe/1.0 (+https://stripe.com/docs/webhooks)';

            if (!\App::runningUnitTests() and !$isRequestFromStripe) {
                return abort( response('Test are running. Wait till they are done.', 500) );
            }

            // Due to security reasons we always need to verify whether a request actually comes from stripe
            // but since we are using testing DB and testing Stripe account then there is no security threat.

            // if($isRequestFromStripe) {
            //     app()->middleware(VerifyWebhookSignature::class);
            // }

            $readOnlyConfig = config('database.connections.mysql-testing');
            \Config::set('database.connections.mysql', $readOnlyConfig);
            \DB::purge('mysql');
        }

        if(!$isRunningTests and !\App::runningUnitTests()) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);    
        }

        $this->app->singleton(StripeClient::class, function()
        {
            return new StripeClient(config('stripe.stripe_secret'));
        });

        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
