<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Orders;

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\V1\Order\StoreRequest;
use Domains\Customer\Aggregates\OrderAggregate;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\Order;
use Domains\Customer\States\Statuses\OrderStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use JustSteveKing\StatusCode\Http;


class StoreController extends Controller
{

    public function __invoke(StoreRequest $request) : Response
    {
        OrderAggregate::retrieve(
            uuid: Str::uuid()->toString(),
        )->createOrder(
            cart:     $request->get('cart'),
            shipping: $request->get('shipping'),
            billing:  $request->get('billing'),
            user:     auth()->check() ? auth()->id(): null,
            email:    auth()->guest()? $request->get('email') : null,
        )->persist();

         return new Response(
             content: null,
             status: Http::CREATED
         );
    }
}


/*
 /*$cart = Cart::query()->where('uuid', $request->get('cart'))->first();
         $order = Order::query()->create([
            'number'        => 'random-order-number' ,
             'state'        => OrderStatus::pending()->label,
             'coupon'       => $cart->coupon,
             //'total'        => 'calculate me',
             'reduction'    => $cart->reduction,
             'user_id'=>auth()->check() ? auth()->id() : null,
             'shipping_id'=> $request->get('shipping'),
             'billing_id'=> $request->get('billing'),
         ]);

        if (auth()->check()) {
            //send a notification to the user
        }
 */
