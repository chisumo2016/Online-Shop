<?php

namespace Domains\Customer\Actions;



use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Domains\Customer\ValueObjects\CartItemValueObject;
use Illuminate\Database\Eloquent\Model;

class AddProductToCart
{
    public  static  function handle(CartItemValueObject $cartItem, Cart $cart): Model
    {
        return  $cart->items()->create($cartItem->toArray());
       //return  CartItem::query()->create($cartItem->toArray());
    }
}
