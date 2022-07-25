<?php

return [
    /*
     * The fully qualified class name of the order item model.
     */
    'order_item_model' => App\Models\Product::class,

    /*
     * The fully qualified class name of the order item nova resource.
     */
    'order_item_nova_resource' => App\Nova\Product::class,

    /*
     * The value from which stock is considered low.
     */
    'low_stock_threshold' => 10,

    /**
     * Route prefix
     */
    'prefix' => '',

    /*
     * Route middleware
     */
    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Stripe Keys
    |--------------------------------------------------------------------------
    |
    | The Stripe publishable key and secret key give you access to Stripe's
    | API. The "publishable" key is typically used when interacting with
    | Stripe.js while the "secret" key accesses private API endpoints.
    |
    */

    'key' => env('STRIPE_KEY'),

    'secret' => env('STRIPE_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Stripe Webhooks
    |--------------------------------------------------------------------------
    |
    | Your Stripe webhook secret is used to prevent unauthorized requests to
    | your Stripe webhook handling controllers. The tolerance setting will
    | check the drift between the current time and the signed request's.
    |
    */

    'webhook' => [
        'secret' => env('STRIPE_WEBHOOK_SECRET'),
        'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
    ],

    'admin_email' => explode(',', env('ADMIN_EMAIL')),

    // TODO: This ain't working... we need this to be translatable
    // Should take another aproach here I guess...
    'countries' => Symfony\Component\Intl\Countries::getNames(app()->getLocale()),
];
