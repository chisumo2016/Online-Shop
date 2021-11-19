<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Customer\Models\Cart;
use Domains\Customer\Models\User;
use Domains\Customer\States\Statuses\CartStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class CartFactory extends Factory
{
    protected $model = Cart::class;

    public function definition(): array
    {
        $useCoupon = $this->faker->boolean();
        return [
            'status'        =>  Arr::random(
                             //array: collect(CartStatus::toLabels())->random()
                             array: CartStatus::toLabels(),
            ),
            'coupon'        =>  null,//$useCoupon ? $this->faker->imei() : null,
            'total'         =>  $this->faker->numberBetween(100, 100000),
            'reduction'     =>  0,//$useCoupon ? $this->faker->numberBetween(250, 2500) : 0,
            'user_id'       =>  User::factory()->create(),
        ];
    }
}
