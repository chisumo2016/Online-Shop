<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Wishlists;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\WishListResource;
use Domains\Customer\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class ShowController extends Controller
{

    public function __invoke(Request $request, Wishlist $wishlist) :JsonResponse
    {
        //$this->authorize('view', $wishlist);
        if (! $wishlist->public) {
            if (auth()->guest() || auth()->id() !== $wishlist->user_id) {
                abort(Http::FORBIDDEN);
            }
           //abort(Http::I_AM_A_TEAPOT);
        }

        return new JsonResponse(
            data: new WishListResource(
                resource: $wishlist
            ),
            status: Http::OK
        );
    }
}
