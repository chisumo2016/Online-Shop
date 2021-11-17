<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Customer\Models\Location;
use Domains\Customer\Models\Order;
use Domains\Customer\Models\User;
use Domains\Customer\States\Statuses\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $useCoupon = $this->faker->boolean();
        $state = Arr::random(OrderStatus::toLabels());
        return [
            //'number' => Str::slug($this->faker->words(4, true)),
            'number'        => $this->faker->bothify(string: 'ORD-####-####-####'),
            'state'         => $state,
            'coupon'        =>  $useCoupon ? $this->faker->imei() : null,
            'total'         =>  $this->faker->numberBetween(100, 100000),
            'reduction'     =>  $useCoupon ? $this->faker->numberBetween(250, 2500) : 0,
            'user_id'       =>  User::factory()->create(),
            'shipping_id'   =>  Location::factory()->create(),
            'billing_id'    =>  Location::factory()->create(),
            'completed_at'  =>  $this->faker->boolean() ? now() : null,
            'cancelled_at'  =>  (OrderStatus:: from($state) === OrderStatus::cancelled()) ? now() : null, //OrderStatus:: from($state) === OrderStatus::cancelled()
            //'cancelled_at'  =>  ($state === 'cancelled'? now() : null, //OrderStatus:: from($state) === OrderStatus::cancelled()

        ];
    }
}
