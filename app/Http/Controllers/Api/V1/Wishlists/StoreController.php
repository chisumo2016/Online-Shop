<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Wishlists;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\WishLists\StoreRequest;
use App\Http\Resources\Api\V1\WishListResource;
use Domains\Customer\Actions\CreateWishList;
use Domains\Customer\Factories\WishListFactory;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

class StoreController extends Controller
{

    public function __invoke(StoreRequest $request):JsonResponse
    {
        $wishlist = CreateWishList::handle(
            object: WishListFactory::make(
                attributes: [
                    'name'      =>  $request->get('name'),
                    'public'    =>  $request->get('public', false),
                    'user'      =>  auth()->id() ?? null,
                ]
             ),
        );
        return new JsonResponse(
            data: new WishListResource(
                resource: $wishlist,
            ),
            status: Http::CREATED,
        );
    }
}
