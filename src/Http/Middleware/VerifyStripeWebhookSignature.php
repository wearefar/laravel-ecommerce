<?php

namespace WeAreFar\Ecommerce\Http\Middleware;

use Closure;
use Stripe\Exception\SignatureVerificationException;
use Stripe\WebhookSignature;

class VerifyStripeWebhookSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            WebhookSignature::verifyHeader(
                $request->getContent(),
                $request->header('Stripe-Signature'),
                config('services.stripe.webhook.secret'),
                config('services.stripe.webhook.tolerance')
            );
        } catch (SignatureVerificationException $exception) {
            abort(403);
        }

        return $next($request);
    }
}
