<?php

namespace Domains\Customer\Actions;

use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Order;
use Domains\Customer\States\Statuses\OrderStatus;
use Domains\Customer\ValueObjects\OrderValueObject;


class CreateOrder
{
   public static function  handle(OrderValueObject $object) : Void
   {
            //Cart lookup
             $cart = Cart::query()
                 ->with('items')
                 ->where('uuid', $object->cart)
                 ->first();

            $order = Order::query()->create([
                   'number'        => 'random-order-number' ,
                   'state'          => OrderStatus::pending()->label,
                   'coupon'         => $cart->coupon,
                   'total'          => 1, //ask
                   'reduction'      => $cart->reduction,
                   'user_id'        =>is_null($object->email) ? $object->user : null,
                   'shipping_id'    => $object->shipping,
                   'billing_id'     => $object->billing,
              ]);

            //Order Items
            $cart->items->each(function (CartItem $item) use ($order){
                $order->lineitems()->create([
                        'name'              =>   $item->purchasable->name,
                        'description'       =>   $item->purchasable->product->description,
                        'retail'            =>   $item->purchasable->retail,
                        'cost'              =>   $item->purchasable->cost,
                        'quantity'          =>   $item->quantity,
                        'purchasable_id'    =>   $item->purchasable->id,
                        'purchasable_type'  =>  get_class($item->purchasable),
                ]);
            });
            //Payment

   }
}
