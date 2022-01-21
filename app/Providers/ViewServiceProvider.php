<?php

namespace App\Providers;

use App\View\Composers\ContentListingOptionsComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('customer.content-listing.request-form', ContentListingOptionsComposer::class);
    }
}