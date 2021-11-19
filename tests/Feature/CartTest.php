<?php


use Domains\Catalog\Models\Variant;
use Domains\Customer\Events\CouponWasApplied;
use Domains\Customer\Events\DecreaseCartQuantity;
use Domains\Customer\Events\IncreaseCartQuantity;
use Domains\Customer\Events\ProductWasAddedToCart;
use Domains\Customer\Events\ProductWasRemovedFromCart;
use Domains\Customer\Models\Cart;
use Domains\Customer\Models\CartItem;
use Domains\Customer\Models\Coupon;
use Domains\Customer\States\Statuses\CartStatus;
use Illuminate\Testing\Fluent\AssertableJson;
use JustSteveKing\StatusCode\Http;

use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertDeleted;
use function Pest\Laravel\delete;
use function Pest\Laravel\patch;
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
it('returns a cart for a logged in user', function (Cart $cart) {
    //$cart = Cart::factory()->create();

    auth()->loginUsingId($cart->user_id);

    get(
        uri: route('api:v1:carts:index'),
    )->assertStatus(
        status: Http::OK
    );
})->with('cart');

it('returns a no content status when a guest tries to retrieve their carts', function () {
    get(
        uri: route('api:v1:carts:index'),
    )->assertStatus(
        status: Http::NO_CONTENT
    );
});

/*add products to a cart*/
it('can add a new product to a cart', function (Cart $cart, Variant $variant) {
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    //$cart       = Cart::factory()->create();
    //$variant    = Variant::factory()->create();

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
})->with('cart','variant');

it('can increase the quantity of an item in the cart', function (CartItem $item) {
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);
    //$item = CartItem::factory()->create(['quantity'=>1]);

    expect($item->quantity)->toEqual(1);

    patch(
        uri: route('api:v1:carts:products:update', [
               'cart'       => $item->cart->uuid,
               'item'       => $item->uuid,
           ]),
        data: ['quantity' => 4],
    )->assertStatus(Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(IncreaseCartQuantity::class);

    /*expect(
        CartItem::query()->find($item->id),
    )->quantity->toEqual(4);*/
})->with('cartItem');
it('can decrease the quantity of an item in the cart', function (CartItem $item) {
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    //$item = CartItem::factory()->create(['quantity'=>3]);

    expect($item->quantity)->toEqual(3);

    patch(
        uri: route('api:v1:carts:products:update', [
               'cart'       => $item->cart->uuid,
               'item'       => $item->uuid,
           ]),
        data: ['quantity' => 1],
    )->assertStatus(Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(DecreaseCartQuantity::class);
    /*expect(
        CartItem::query()->find($item->id),
    )->quantity->toEqual(1);*/
})->with('3CartItems');
it('removes an item from the cart when the quantity is zero', function (CartItem $item) {
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    //$item = CartItem::factory()->create(['quantity'=>3]);

    expect($item->quantity)->toEqual(3);

    patch(
        uri: route('api:v1:carts:products:update', [
               'cart'       => $item->cart->uuid,
               'item'       => $item->uuid,
           ]),
        data: ['quantity' => 0],
    )->assertStatus(Http::ACCEPTED);

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(ProductWasRemovedFromCart::class);
})->with('3CartItems');
it('can remove an item from the cart', function (){
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);
    $item = CartItem::factory()->create(['quantity'=>3]);

    delete(
        uri: route('api:v1:carts:products:delete', [
            'cart'=> $item->cart->uuid,
            'item'=> $item->uuid
           ])
    )->assertStatus(Http::ACCEPTED);

    //assertDeleted($item);
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(ProductWasRemovedFromCart::class);
});
it('can apply a coupon to the cart', function (){
    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 0);

    $coupon = Coupon::factory()->create();

    $cart = Cart::factory()->create();

    expect($cart)
        ->reduction
        ->toEqual(0);

    post(
        uri: route('api:v1:carts:coupons:store', $cart->uuid),
        data: ['code' => $coupon->code,]
    )->assertStatus(Http::ACCEPTED);

    /*expect(
        Cart::query()->find($cart->id)
    )->reduction->toEqual($coupon->reduction)->coupon->toEqual($coupon->code);*/

    expect(EloquentStoredEvent::query()->get())->toHaveCount(count: 1);
    expect(EloquentStoredEvent::query()->first()->event_class)->toEqual(CouponWasApplied::class);

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
//assertDatabaseMissing('cart_items', $item->toArray());
