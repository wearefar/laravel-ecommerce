<?php

namespace WeAreFar\Ecommerce\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use WeAreFar\Ecommerce\Events\OrderSucceeded;
use WeAreFar\Ecommerce\Notifications\NewOrderNotification;

class SendNewOrderNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderSucceeded $event)
    {
        Notification::route('mail', config('ecommerce.admin_email'))
            ->notify(new NewOrderNotification($event->order));
    }
}
