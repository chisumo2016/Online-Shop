<?php

declare(strict_types=1);

namespace Domains\Fulfilment\Jobs\Stripe;

use Domains\Fulfilment\Actions\RetrieveOrderStateFromPaymentIntent;
use Domains\Fulfilment\Aggregates\OrderAggregate;
use Domains\Fulfilment\Models\Order;
use Domains\Fulfilment\States\Statuses\OrderStatus;
use Domains\Fulfilment\ValueObjects\Stripe\PaymentIntent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessPaymentIntent implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;

    public function __construct(
        public PaymentIntent $object,
    ) {}

    public function handle(): void
    {


        Log::info(
            message: 'Process payment intent from a webhook job',
            context: [
                'id'        => $this->object->id,
                'object'    => $this->object->object
             ],
        );

        //look up an order by intent id based off the object id
         $order = Order::query()->where('intent_id', $this->object->id)->first();

         //create a map of stripe webhooks events to order statusses
        $state = RetrieveOrderStateFromPaymentIntent::handle($this->object);


         //Using the order Aggregate retrieve based on the order uuid, a call the  updateOrderStatus method
        OrderAggregate::retrieve(
            uuid: $order->uuid,
        )->updateState(
            id: $order->id,
            state: $state->value,
        )->persist();


        //Get the order aggregate
        //update the status
        //react tp send a notification to the end user

    }
}

/*
 *
 * match ($this->object->object) {
            'succeeded'     => OrderStatus::completed(),
            'failed'        => OrderStatus::declined(),
            'refunded'      => OrderStatus::refunded(),
            default         => OrderStatus::pending(),

          };
 */
