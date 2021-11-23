<?php

namespace Domains\Customer\Factories;

use Domains\Customer\Models\Order;
use Domains\Customer\ValueObjects\OrderValueObject;

class OrderFactory
{
   public static  function  make(array $attributes): OrderValueObject
   {
      return new OrderValueObject(
          cart:     $attributes['cart'],
          email:    $attributes['email'],
          shipping: $attributes['shipping'],
          billing:  $attributes['billing'],
          user:     $attributes['user']
      );

   }
}
