<?php

namespace WeAreFar\Ecommerce\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use WeAreFar\Ecommerce\Events\OrderSucceeded;
use WeAreFar\Ecommerce\Notifications\OrderConfirmationNotification;

class SendOrderConfirmationNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderSucceeded $event)
    {
        $event->order->customer->notify(new OrderConfirmationNotification($event->order));
    }
}
