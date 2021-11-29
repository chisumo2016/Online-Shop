<?php
declare(strict_types=1);

namespace Domains\Fulfilment\Actions;

use Illuminate\Database\Eloquent\Model;

class UpdateOrderStates
{
    public static function  handle(Model $order, string $state) : Void
    {
        $order->update([
            'state' => $state
            ]);
    }
}
