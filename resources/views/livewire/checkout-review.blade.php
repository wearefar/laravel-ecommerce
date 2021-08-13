<div x-data x-on:step-updated.window="if ($event.detail.step == 4) $wire.clearCart()">
  <div>
    @foreach($order->items as $item)
      <div class="{{ ! $loop->first ? 'border-t border-pearl-dark' : '' }}">
        <x-ecommerce::checkout.order-item :item="$item" />
      </div>
    @endforeach
  </div>
  <div class="text-sm">
    <div class="flex justify-between pt-4 pb-2 border-t border-pearl-dark">
      <div class="">Subtotal</div>
      <div class="">{{ money($order->units_total) }}</div>
    </div>
    <div class="flex justify-between pt-2 pb-4">
      <div class="">@lang('Shipping')</div>
      <div class="">{{ money($order->adjustments_total) }}</div>
    </div>
    <div class="flex justify-between pt-4 pb-2 border-t border-pearl-dark mb-4">
      <div class="">Total</div>
      <div class="">{{ money($order->total) }}</div>
    </div>
  </div>
</div>
