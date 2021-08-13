<?php

namespace WeAreFar\Ecommerce\Http\Livewire;

use Livewire\Component;
use WeAreFar\Ecommerce\Models\Order;

class ShoppingCart extends Component
{
    public $cart;

    public function mount()
    {
        $this->cart = Order::with('items')->findOrNew(session('cart'));
    }

    public function add(int $id, int $quantity = 1)
    {
        if (!$this->cart->exists) {
            $this->cart->save();

            session()->put('cart', $this->cart->id);
        }

        // I don't like this...
        // Can't figure out how could have model binding here...
        // This will get harder if the order items is a polymorphic relationship
        // How livewire can instantiate the model?
        // How will livewire will know what class should look for?
        $productClass = config('ecommerce.order_item_model');
        $item = $productClass::find($id);

        $this->cart->addItem($item, $quantity);

        $this->dispatchBrowserEvent('update-cart-count', ['count' => $this->units]);
    }

    public function remove(int $id)
    {
        // Maybe we should check if cart exists here
        // although it exists implicitly

        $productClass = config('ecommerce.order_item_model');
        $item = $productClass::find($id);

        $this->cart->removeItem($item);

        $this->dispatchBrowserEvent('update-cart-count', ['count' => $this->units]);
    }

    public function increment(int $id)
    {
        $this->add($id, 1);
    }

    public function decrement(int $id)
    {
        $this->add($id, -1);
    }

    public function getUnitsProperty()
    {
        return $this->cart->items->sum('pivot.quantity');
    }

    public function render()
    {
        return view('ecommerce::livewire.shopping-cart');
    }
}
