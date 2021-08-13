{{ $order->customer->name }}<br>
{{ $order->shippingAddress->address_line_1 }}<br>
@if($order->shippingAddress->address_line_2)
  {{ $order->shippingAddress->address_line_2 }}<br>
@endif
{{ $order->shippingAddress->zip }} {{ $order->shippingAddress->city }}<br>
{{ Symfony\Component\Intl\Countries::getName($order->shippingAddress->country, app()->getLocale()) }}<br>
{{ $order->shippingAddress->phone }}
