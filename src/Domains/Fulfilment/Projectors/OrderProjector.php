<?php

namespace Domains\Fulfilment\Projectors;

use Database\Factories\OrderFactory;
use Domains\Fulfilment\Actions\CreateOrder;
use Domains\Fulfilment\Events\OrderWasCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class OrderProjector extends Projector
{
      public function onOrderWasCreated(OrderWasCreated $event): void
    {
        //factor
        //value object
        //perform actions
        $object = OrderFactory::make(
            attributes: [
                'cart'     => $event->cart,
                'billing'  => $event->billing,
                'shipping' => $event->shipping,
                'email'    => $event->email,
                'user'     => $event->user,
                //'intent' => $event->intent,
            ],
        );

        CreateOrder::handle(
            object: $object,
        );
    }
}
