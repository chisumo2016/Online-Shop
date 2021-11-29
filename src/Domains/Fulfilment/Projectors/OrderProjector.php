<?php

namespace Domains\Fulfilment\Projectors;

use Domains\Fulfilment\Factories\OrderFactory;
use Domains\Fulfilment\Actions\CreateOrder;
use Domains\Fulfilment\Actions\UpdateOrderStates;
use Domains\Fulfilment\Events\OrderStateWasUpdated;
use Domains\Fulfilment\Events\OrderWasCreated;
use Domains\Fulfilment\Models\Order;
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
                'intent'   => $event->intent,
            ],
        );

        CreateOrder::handle(
            object: $object,
        );
    }

    public function  onOrderStateWasUpdated(OrderStateWasUpdated $event):void
    {
        $order = Order::query()->find(
            id: $event->id,
        );

        UpdateOrderStates::handle(
            order: $order,
            state: $event->state,
        );
        /*$order->update(
            attributes: [
                'status' => $event->status,
            ],
        );*/
    }
}
