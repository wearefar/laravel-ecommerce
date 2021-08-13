<?php

namespace WeAreFar\Ecommerce\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use WeAreFar\Ecommerce\Events\OrderShipped;
use WeAreFar\Ecommerce\Notifications\OrderShippedNotification;

class SendOrderShippedNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderShipped $event)
    {
        $event->order->customer->notify(new OrderShippedNotification($event->order));
    }
}
