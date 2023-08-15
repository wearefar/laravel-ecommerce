<?php

namespace WeAreFar\Ecommerce\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stripe\Event as StripeEvent;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Response;
use WeAreFar\Ecommerce\Events\OrderSucceeded;
use WeAreFar\Ecommerce\Http\Middleware\VerifyStripeWebhookSignature;
use WeAreFar\Ecommerce\Models\Payment;

class StripeWebhookController extends Controller
{
    public function __construct()
    {
        if (config('ecommerce.webhook.secret')) {
            $this->middleware(VerifyStripeWebhookSignature::class);
        }
    }

    public function __invoke(Request $request)
    {
        Stripe::setApiKey(config('ecommerce.secret'));

        $payload = $request->getContent();

        try {
            $event = StripeEvent::constructFrom(
                json_decode($payload, true)
            );
        } catch (\UnexpectedValueException $e) {
            abort(400);
        }

        $method = 'handle' . Str::studly(str_replace('.', '_', $event->type));

        if (method_exists($this, $method)) {
            return $this->{$method}($event->data->object);
        }

        return $this->missingMethod();
    }

    public function handlePaymentIntentSucceeded($paymentIntent)
    {
        try {
            $payment = Payment::where('stripe_id', $paymentIntent->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return new Response('Error: Payment not found.', 200);
        }

        $payment->update([
            'status' => $paymentIntent->status,
            'card_brand' => $paymentIntent->charges->data[0]->payment_method_details->card->brand ?? null,
            'card_last_four' => $paymentIntent->charges->data[0]->payment_method_details->card->last4 ?? null,
            'stripe_error_message' => $paymentIntent->charges->data[0]->failure_message ?? null,
        ]);

        if ($payment->order->status == 'succeeded') {
            return new Response('Warning: Order already handled.', 200);
        }

        $payment->order->update(['status' => 'succeeded']);

        event(new OrderSucceeded($payment->order));

        return $this->successMethod();
    }

    public function handlePaymentIntentPaymentFailed($paymentIntent)
    {
        try {
            $payment = Payment::where('stripe_id', $paymentIntent->id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return new Response('Error: Payment not found.', 200);
        }

        $payment->update([
            'status' => $paymentIntent->status,
            'card_brand' => $paymentIntent->charges->data[0]->payment_method_details->card->brand ?? null,
            'card_last_four' => $paymentIntent->charges->data[0]->payment_method_details->card->last4 ?? null,
            'stripe_error_message' => $paymentIntent->charges->data[0]->failure_message,
        ]);

        $payment->order->update(['status' => 'failed']);

        return $this->successMethod();
    }

    public function successMethod()
    {
        return new Response('Webhook handled', 200);
    }

    public function missingMethod()
    {
        abort(400);
    }
}
