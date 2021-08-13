<?php

namespace WeAreFar\Ecommerce\Http\Controllers;

use WeAreFar\Ecommerce\Models\Order;

class CheckoutController extends Controller
{
    public function __invoke()
    {
        $order = Order::with('items.media')->find(session('cart'));

        if (is_null($order) || $order->items->isEmpty()) {
            return redirect(route_l10n('home'));
        }

        return view('ecommerce::checkout', compact('order'));
    }
}
