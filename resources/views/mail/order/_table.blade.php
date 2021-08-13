@component('mail::table')
| @lang('Product') |  Total  |
| :------ | -------:|
@foreach ($order->items as $item)
@php

$name = $item->name;
$quantity = $item->pivot->quantity;
$price = money($item->pivot->unit_price);
$total = money($item->pivot->total);

@endphp
| {{ $name }}<br><small>{{ $quantity }} &times; {{ $price }}</small> | {{ $total }} |
@endforeach
| Subtotal | {{ money($order->items_total) }} |
| @lang('Shipping') | {{ money($order->adjustments_total) }} |
| **Total** | **{{ money($order->total) }}** |
@endcomponent
