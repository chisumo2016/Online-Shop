<?php
declare(strict_types=1);
namespace Domains\Customer\Actions;

use Domains\Customer\Models\Wishlist;
use Domains\Customer\ValueObjects\WishListValueObject;
use Illuminate\Database\Eloquent\Model;

class CreateWishList
{
    public static  function  handle(WishListValueObject $object) :Model
    {
       return Wishlist::query()->create([
           'name'       => $object->name,
           'public'     => $object->public,
           'user_id'    => $object->user,
       ]);
    }
}
