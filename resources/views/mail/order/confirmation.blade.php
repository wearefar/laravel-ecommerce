@component('mail::message')
# @lang('Hi :name', ['name' => $order->customer->name]),

@lang('Thank you for your order. The payment has been confirmed and your order has been processed.')

@php
$address = $order->shippingAddress;
@endphp

@component('mail::panel')
@lang('Order code'): **{{ $order->code }}**
@endcomponent


@component('mail::panel')
**@lang('Shipping Address')**<br>
@include('ecommerce::mail.order._address')
@endcomponent

@include ('ecommerce::mail.order._table')

@lang('Thanks'),<br>
{{ config('app.name') }}
@endcomponent
