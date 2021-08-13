<?php

namespace WeAreFar\Ecommerce\Listeners;

use WeAreFar\Ecommerce\Events\OrderSucceeded;

class ReduceStock
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderSucceeded $event)
    {
        $event->order->items()->each(function ($item) {
            if (! is_null($item->stock)) {
                $item->decrement('stock', $item->pivot->quantity);
            }
        });
    }
}
