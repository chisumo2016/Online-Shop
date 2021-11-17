<?php


use Domains\Catalog\Models\Variant;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\User;
use Domains\Customer\States\Statuses\CartStatus;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;

use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

use function Pest\Laravel\post;
use function Pest\Laravel\get;

/*Create a cart*/
it('creates a cart for an unauthenticated user', function () {
    post(
        uri: route('api:v1:carts:store'),
    )->assertStatus(
         status: Http::CREATED
     )->assertJson(
         fn (AssertableJson $json) =>
         //dd($json);
        $json->where('type', 'cart')
            ->where('attributes.status', CartStatus::pending()->label)
            ->etc()
     );
    //->assertJsonPath(path: 'data.type', expect: 'cart')
});

/*do we have an active cart*/
it('returns a cart for a logged in user', function () {
    $cart = Cart::factory()->create();

    auth()->loginUsingId($cart->user_id);

    get(
        uri: route('api:v1:carts:index'),
    )->assertStatus(
        status: Http::OK
    );
});

it('returns a no content status when a guest tries to retrieve their carts', function () {
    get(
        uri: route('api:v1:carts:index'),
    )->assertStatus(
        status: Http::NO_CONTENT
    );
});

/*add products to a cart*/
it('can add a new product to a cart', function () {
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    $cart       = Cart::factory()->create();
    $variant    = Variant::factory()->create();

    post(
        uri: route('api:v1:carts:products:store', $cart->uuid),
        data: [
                'quantity' => 1,
                'purchasable_id' => $variant->id,
                'purchasable_type' => 'variant'
             ],
    )->assertStatus(
        status: Http::CREATED
    );
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(ProductWasAddedToCart::class);

    //dd(Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent::query()->get());
});
/*when logged in we can create a cart , and it is assigned to our user*/
/*when not logged in we can create a cart , and the cart id is stored in a session variable*/






//)->assertJson(fn (AssertableJson $json) =>
//    //dd($json);
//$json->where('type', 'cart-item')
//    ->where('attributes.quantity', 1)
//    ->where('attributes.item.id', $variant->id)
//    ->etc()
//);
