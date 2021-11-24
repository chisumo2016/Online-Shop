<?php

namespace App\Providers;

use App\Http\Middleware\Stripe\Signature\SignatureValidationMiddleware;
use Illuminate\Support\ServiceProvider;
use Stripe\Stripe;

class StripeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() : void
    {
       /* $this->app->singleton(
            abstract: SignatureValidationMiddleware::class,
            concrete:fn() =>Stripe::setApiKey(
                apiKey: config('services.stripe.key'),
                ),

        );*/
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
