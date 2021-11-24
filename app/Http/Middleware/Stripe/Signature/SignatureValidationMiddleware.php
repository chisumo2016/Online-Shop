<?php
declare(strict_types=1);

namespace App\Http\Middleware\Stripe\Signature;

use Closure;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Webhook;
use UnexpectedValueException;

class SignatureValidationMiddleware
{
    /*public function  __construct(
        protected  Stripe $stripe
    ){}*/

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next) : mixed
    {
        /*Stripe::setApiKey(
            apiKey: config('services.stripe.key'),
        );*/

        //dump($request->header('Stripe-Signature'));

        try {
            $event = Webhook::constructEvent(
                payload: $request->getContent(),
                sigHeader: $request->header(
                   key: 'Stripe-Signature'
                ),
                secret: config('services.stripe.endpoint_secret')
            );
        }catch (UnexpectedValueException $e){
           //Invalid payload
            abort(Http::UNPROCESSABLE_ENTITY);

        }catch (SignatureVerificationException $e){
            abort(Http::UNAUTHORIZED);
        }

        $request->merge([
            'payload' => $event
          ]);

        return $next($request);
    }
}
