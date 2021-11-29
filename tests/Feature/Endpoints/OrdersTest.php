<?php

use Domains\Fulfilment\Events\OrderWasCreated;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Location;
use Domains\Fulfilment\Models\Order;

use Domains\Customer\Models\User;
use JustSteveKing\StatusCode\Http;

use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

use function Pest\Laravel\post;

it('can create an order from a cart using the API when not logged in', function (){
    //expect(Order::query()->count())->toEqual(0);
    expect(EloquentStoredEvent::query()->get())->toHaveCount(0);

     $item = CartItem::factory()->create();
     $location = Location::factory()->create();

    post(
        uri: route('api:v1:orders:store'),
        data: [
                 'cart'       =>    $item->cart->uuid,
                 'email'      =>    'bchisumo74@gmail.com',
                 'shipping'   =>    $location->id,
                 'billing'    =>    $location->id,
                 'intent'    =>    '12345',

             ],
    )->assertStatus(Http::ACCEPTED); //ACCEPTED

    //expect(Order::query()->count())->toEqual(1);
    expect(EloquentStoredEvent::query()->get())->toHaveCount(1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(OrderWasCreated::class);
});

it('can create an order from a cart using the API when logged in', function (){

    expect(EloquentStoredEvent::query()->get())->toHaveCount(0);

    auth()->login( $user = User::factory()->create());

    $item = CartItem::factory()->create();
    $location = Location::factory()->create();

    post(
        uri: route('api:v1:orders:store'),
        data: [
                 'cart'       =>    $item->cart->uuid,
                 'email'      =>    'bchisumo74@gmail.com',
                 'shipping'   =>    $location->id,
                 'billing'    =>    $location->id,
                 'intent'    =>    '12345',
             ],
    )->assertStatus(Http::ACCEPTED); //ACCEPTED

    //expect(Order::query()->count())->toEqual(1);
    expect(EloquentStoredEvent::query()->get())->toHaveCount(1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(OrderWasCreated::class);
});
