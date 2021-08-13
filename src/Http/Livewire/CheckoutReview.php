<?php

namespace WeAreFar\Ecommerce\Http\Livewire;

use Livewire\Component;
use WeAreFar\Ecommerce\Models\Order;

class CheckoutReview extends Component
{
    public $order;

    public function clearCart()
    {
        session()->forget('cart');
    }

    public function render()
    {
        return view('ecommerce::livewire.checkout-review');
    }
}
