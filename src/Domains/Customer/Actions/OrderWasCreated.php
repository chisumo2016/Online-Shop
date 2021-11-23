<?php

namespace Domains\Customer\Actions;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class OrderWasCreated extends ShouldBeStored
{
   public function __construct(
       public string $cart,
       public null|string $email,
       public  int $shipping,
       public  int $billing,
       public null|int $user,

   ){}
}
