<?php

namespace Domains\Fulfilment\Aggregates;

use Domains\Fulfilment\Events\OrderStateWasUpdated;
use Domains\Fulfilment\Events\OrderWasCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class OrderAggregate extends AggregateRoot
{
   public function createOrder(
       string $cart,
       int $shipping,
       int $billing,
       null|int $user,
       null|string $email,
       string $intent): self
   {
       $this->recordThat(
           domainEvent: new OrderWasCreated(
                cart:      $cart,
                email:     $email,
                shipping:  $shipping,
                billing:   $billing,
                user:      $user,
                 intent :  $intent
             ),
       );
          return $this;
   }

   public function updateState(int $id, string $state):self
   {
      $this->recordThat(
          domainEvent: new OrderStateWasUpdated(
              id: $id,
              state: $state
          ),
      );
      return $this;

   }
}
