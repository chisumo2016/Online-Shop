<?php

namespace App\Providers;

use Domains\Customer\Projectors\CartProjector;
use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;

class EventSourcingServiceProvider extends ServiceProvider
{

    public function register() : void
    {
        // adding a single projector
        Projectionist::addProjectors(
            [
                CartProjector::class
            ]
        );
    }


    public function boot() : void
    {
        //
    }
}
