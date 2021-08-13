<?php

namespace WeAreFar\Ecommerce\Http\Livewire;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use WeAreFar\Ecommerce\Models\Address;
use WeAreFar\Ecommerce\Models\Customer;
use WeAreFar\Ecommerce\Models\Order;

class CheckoutShipping extends Component
{
    public $editing = true;

    public $name;
    public $email;
    public $address_line_1;
    public $zip;
    public $city;
    public $state;
    public $country = 'ES'; // TODO: deal with this
    public $phone;

    public $client_secret;

    public function mount()
    {
        // TODO
        // set initial values if the user
        // already filled up the form before
    }

    public function submit()
    {
        $validated = $this->validate([
            'email' => 'required|email',
            'name' => 'required',
            'address_line_1' => 'required',
            'zip' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => [
                'required',
                Rule::in(array_keys(config('ecommerce.countries'))),
            ],
            'phone' => 'required',
        ]);

        // TODO: should take it from the controller...
        $order = Order::find(session('cart'));

        $shippingAddress = Address::updateOrCreate(
            ['id' => $order->shipping_address_id],
            $validated
        );

        // TODO: Maybe rename Customer to Guest
        // TODO: Auth User Customer
        $customer = Customer::updateOrCreate(
            // 'email' => $order->customer->email
            ['id' => $order->customer_id],
            [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'locale' => app()->getLocale(),
            ]
        );

        $order->shippingAddress()->associate($shippingAddress);
        $order->customer()->associate($customer);

        // TODO: Ensure order status is not succeded or something...
        $order->status = 'draft';
        // what about pending anb stuff...

        // TODO: Order adjustments shipping
        // $order->updateTotals();

        $order->save();


        // Update or Create Stripe Payment Intent
        // and store it in the database
        Stripe::setApiKey(config('ecommerce.secret'));

        $paymentIntent = $order->payment ?
            PaymentIntent::update(
                $order->payment->stripe_id,
                ['amount' => $order->total]
            ) :
            PaymentIntent::create([
                'amount' => $order->total,
                'currency' => 'eur',
                'description' => "Order #{$order->id}",
            ]);

        $order->payment()->updateOrCreate(
            ['stripe_id' => $paymentIntent->id],
            [
                'stripe_id' => $paymentIntent->id,
                'amount' => $paymentIntent->amount,
                'status' => $paymentIntent->status,
            ]
        );

        // Send the Stripe Payment Intent client_secret to the frontend
        // REVIEW: maybe dispatch browser event...
        $this->client_secret = $paymentIntent->client_secret;

        $this->emit('cart-updated');

        $this->dispatchBrowserEvent('step-updated', ['step' => 2]);
    }

    public function render()
    {
        return view('ecommerce::livewire.checkout-shipping');
    }
}
