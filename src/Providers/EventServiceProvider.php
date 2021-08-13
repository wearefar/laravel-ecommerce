<?php

namespace WeAreFar\Ecommerce\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use WeAreFar\Ecommerce\Events\OrderShipped;
use WeAreFar\Ecommerce\Events\OrderSucceeded;
use WeAreFar\Ecommerce\Listeners\ReduceStock;
use WeAreFar\Ecommerce\Listeners\SendNewOrderNotification;
use WeAreFar\Ecommerce\Listeners\SendOrderConfirmationNotification;
use WeAreFar\Ecommerce\Listeners\SendOrderShippedNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        OrderSucceeded::class => [
            ReduceStock::class,
            SendOrderConfirmationNotification::class,
            SendNewOrderNotification::class,
        ],
        OrderShipped::class => [
            SendOrderShippedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
