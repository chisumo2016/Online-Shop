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

        //Get the order aggreagte
        //update the status
        //react tp send a notification to the end user

    }
}
