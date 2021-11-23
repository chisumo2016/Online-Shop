<?php

namespace Domains\Fulfilment\Aggregates;

use Domains\Fulfilment\Events\OrderWasCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class OrderAggregate extends AggregateRoot
{
   public function createOrder(string $cart, int $shipping, int $billing,null|int $user, null|string $email): self
   {
       $this->recordThat(
           domainEvent: new OrderWasCreated(
                cart:       $cart,
                email:     $email,
                shipping:  $shipping,
                billing:   $billing,
                user:      $user
             )
       );
          return $this;
   }
}
