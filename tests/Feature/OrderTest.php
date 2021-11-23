<?php


use Domains\Customer\Actions\OrderWasCreated;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Location;
use Domains\Customer\Models\Order;

use Domains\Customer\Models\User;
use JustSteveKing\StatusCode\Http;

use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

use function Pest\Laravel\post;

it('can create an order from a cart for an unauthenticated user', function (CartItem $cartItem){
    //expect(Order::query()->count())->toEqual(0);
    expect(EloquentStoredEvent::query()->get())->toHaveCount(0);
    $location = Location::factory()->create();

    post(
        uri: route('api:v1:orders:store'),
        data:[
              'cart' => $cartItem->cart->uuid,
               'email'=>'bchisumo74@gmail.com',
               'shipping'=>$location->id,
               'billing'=> $location->id,
             ]
    )->assertStatus(Http::CREATED);

    //expect(Order::query()->count())->toEqual(1);
    //expect(Order::query()->first()->shipping_id)->toEqual($location->id);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(OrderWasCreated::class);

})->with('3CartItems');
it('can create an order from a cart for an authenticated user', function (CartItem $cartItem){

    auth()->login(User::factory()->create());

    //expect(Order::query()->count())->toEqual(0);
    expect(EloquentStoredEvent::query()->get())->toHaveCount(0);

    $location = Location::factory()->create();

    post(
        uri: route('api:v1:orders:store'),
        data:[
                 'cart' => $cartItem->cart->uuid,
                 'shipping' => $location->id,
                 'billing' => $location->id,
             ]
    )->assertStatus(Http::CREATED);


    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(OrderWasCreated::class);

})->with('3CartItems');



//dd(EloquentStoredEvent::query()->first());

/*expect(Order::query()->count())->toEqual(1);
expect(Order::query()->first()->shipping_id)->toEqual($location->id);
expect(Order::query()->first()->user_id)->toEqual(auth()->id());*/
