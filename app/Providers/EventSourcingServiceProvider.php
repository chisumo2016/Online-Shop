<?php

namespace App\Providers;

use Domains\Customer\Projectors\CartProjector;
use Domains\Customer\Projectors\OrderProjector;
use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;

class EventSourcingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // adding a single projector
        Projectionist::addProjectors(
            [
                CartProjector::class,
                OrderProjector::class
            ]
        );
    }


    public function boot(): void
    {
        //
    }
}
