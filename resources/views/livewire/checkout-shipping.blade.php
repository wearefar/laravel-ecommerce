<div
  x-data
  x-on:step-updated.window="$wire.set('editing', $event.detail.step == 1)"
>
  @if ($editing)
    <x-ecommerce::checkout.shipping-form />
  @else
    @include('ecommerce::components.checkout.shipping-data')
  @endif
</div>
