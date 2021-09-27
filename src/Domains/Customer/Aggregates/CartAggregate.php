<?php
declare(strict_types=1);

namespace Domains\Customer\Aggregates;


use Domains\Customer\Events\DecreaseCartQuantity;
use Domains\Customer\Events\IncreaseCartQuantity;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemovedFromCart;
use Domains\Customer\Events\QuantityEvent;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class CartAggregate extends AggregateRoot
{
    public  function addProduct(int $purchasableID, int $cartID, string $type): self
    {
        $this->recordThat(new ProductWasAddedToCart(
               purchasableID: $purchasableID,
               cartID:     $cartID,
               type: $type
            ),
        );
        return $this;
    }

    public  function removeProduct(int   $purchasableID , int $cartID,  string $type) : self
    {
       $this->recordThat(
           domainEvent: new ProductWasRemovedFromCart(
               purchasableID: $purchasableID,
               cartID:     $cartID,
               type: $type
           ),
       );

       return  $this;
    }
    public function increaseQuantity(int $cartItemID,     int $quantity, int $cartID): self
    {
       $this->recordThat(
           domainEvent: new IncreaseCartQuantity(
              cartItemID: $cartItemID,
              cartID: $cartID,
              quantity: $quantity
           ),

       );
        return  $this;
    }
    public function decreaseQuantity(int $cartItemID,     int $quantity, int $cartID): self
    {
        $this->recordThat(
            domainEvent: new DecreaseCartQuantity(
                cartItemID: $cartItemID,
                quantity:   $quantity,
                cartID:     $cartID,
            )
        );
        return  $this;
    }
}
