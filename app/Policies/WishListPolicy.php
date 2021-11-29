<?php
declare(strict_types=1);

namespace App\Policies;

use Domains\Customer\Models\Wishlist;
use  Illuminate\Auth\Access\Response;

use Domains\Customer\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WishListPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user) : Response|bool
    {
        //
    }

    public function view(User $user, WishList $wishList) : Response|bool
    {
        if ($wishList->public) {
            return true;
        }
        return  $user->id === $wishList->user_id;
    }

    public function create(User $user): Response|bool
    {
        //
    }

    public function update(User $user, WishList $wishList) : Response|bool
    {
        //
    }

    public function delete(User $user, WishList $wishList) : Response|bool
    {
        //
    }

    public function restore(User $user, WishList $wishList) : Response|bool
    {
        //
    }

    public function forceDelete(User $user, WishList $wishList) : Response|bool
    {
        //
    }
}
