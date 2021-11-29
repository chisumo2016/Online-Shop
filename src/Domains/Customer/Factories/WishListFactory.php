<?php
declare(strict_types=1);

namespace Domains\Customer\Factories;

use Domains\Customer\ValueObjects\WishListValueObject;

class WishListFactory
{
    public static function  make(array $attributes) : WishListValueObject
    {
        return new WishListValueObject(
            name:   $attributes['name'],
            public: $attributes['public'],
            user:   $attributes['user'],
        );
    }
}
