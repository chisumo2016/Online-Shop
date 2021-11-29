<?php

namespace Domains\Fulfilment\ValueObjects;

class OrderValueObject
{
   public function __construct(
       public string $cart,
       public null|string $email,
       public  int $shipping,
       public  int $billing,
       public null|int $user,
       public null|string $intent,
   ){}
}
