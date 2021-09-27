<?php

namespace Domains\Customer\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class QuantityEvent extends ShouldBeStored
{
   public  function __construct(
       public  int $cartID,
       public  int $cartItemID,
       public  int $quantity,
   ){}
}
