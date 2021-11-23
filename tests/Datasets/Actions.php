<?php

use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Location;
use Domains\Customer\Models\User;
use Domains\Customer\ValueObjects\OrderValueObject;

dataset('OrderValueObject', [
    fn() => new OrderValueObject(
        //cart:     Cart::factory()->create()->uuid,
        cart:     CartItem::factory()->create()->cart->uuid,
        email:    null,
        shipping: $location = Location::factory()->create()->id,
        billing:  $location,
        user:     User::factory()->create()->id
    ),
]);
