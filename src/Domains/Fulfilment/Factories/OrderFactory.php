<?php

namespace Domains\Fulfilment\Factories;

use Domains\Fulfilment\Models\Order;
use Domains\Fulfilment\ValueObjects\OrderValueObject;

class OrderFactory
{
   public static  function  make(array $attributes): OrderValueObject
   {
      return new OrderValueObject(
          cart:     $attributes['cart'],
          email:    $attributes['email'],
          shipping: $attributes['shipping'],
          billing:  $attributes['billing'],
          user:     $attributes['user'],
          intent:   $attributes['intent'],
      );

   }
}
