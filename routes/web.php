<?php

use Illuminate\Support\Facades\Route;
use WeAreFar\Ecommerce\Http\Controllers\CheckoutController;
use WeAreFar\Ecommerce\Http\Controllers\StripeWebhookController;

Route::get('/checkout', CheckoutController::class)->name('checkout');

Route::post('stripe/webhook', StripeWebhookController::class)->name('stripe-webhook');
