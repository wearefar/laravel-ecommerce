@component('mail::message')
# @lang('Hi :name', ['name' => $order->customer->name]),

@lang('Your order :code has been shipped. Below you will find the shipping information.', ['code' => $order->code])

@php
$address = $order->shippingAddress;
@endphp

@if($order->tracking_number)
  @component('mail::panel')
  @lang('Tracking number'): **{{ $order->tracking_number }}**
  @endcomponent
@endif

@component('mail::panel')
**@lang('Shipping Address')**<br>
@include('ecommerce::mail.order._address')
@endcomponent

@include ('ecommerce::mail.order._table')

@lang('Thanks'),<br>
{{ config('app.name') }}
@endcomponent
