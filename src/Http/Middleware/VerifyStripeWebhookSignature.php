<?php

namespace WeAreFar\Ecommerce\Http\Middleware;

use Closure;
use Stripe\Exception\SignatureVerificationException;
use Stripe\WebhookSignature;
use Symfony\Component\HttpFoundation\Response;

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
                config('ecommerce.webhook.secret'),
                config('ecommerce.webhook.tolerance')
            );
        } catch (SignatureVerificationException $exception) {
            return new Response('Webhook signature verification failed', 403);
        }

        return $next($request);
    }
}
