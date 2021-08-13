<div
  x-data="{ open: false }"
  x-init="$dispatch('update-cart-count', { count: {{ $this->units }} })"
  x-on:toggle-cart.window="open = !open"
  x-on:add-to-cart.window="$wire.add($event.detail.productId, $event.detail.quantity); open = true"
>
  <x-ecommerce::slide-over>
    <div class="flex flex-col justify-between h-full">
      <div>
        <h1 class="font-display text-4xl md:text-5xl text-center leading-tight">@lang('Your Cart')</h1>
        <p class="text-sm text-center mb-4 md:mb-10">
          @if($cart->items->isEmpty())
            @lang('is currently empty')
          @else
            {{ trans_choice('contains 1 product|contains :count products', $this->units, ['count' => $this->units]) }}
          @endif
        </p>
      </div>

      @if($cart->items->isEmpty())

      <div class="flex-grow overflow-y-auto">
        <div class="h-full flex items-center justify-center">
          <div class="w-full text-center">
            <div class="text-sm mb-6">
              @lang("Looks like there's nothing in your cart.")
            </div>
            <a href="{{ route_l10n('catalog') }}" class="block px-10 py-3 font-semibold text-sm border border-black hover:bg-black hover:text-white transition-colors duration-300">@lang('Start Shopping')</a>
          </div>
        </div>
      </div>

      @else

      <div class="flex-grow overflow-y-auto">
        @foreach($cart->items as $item)
          <x-ecommerce::cart-item :item="$item" />
        @endforeach
      </div>

      <div class="text-sm">
        <div class="flex justify-between py-2 border-t border-pearl-dark">
          <div class="">@lang('Subtotal')</div>
          <div class="">{{ money($cart->items_total) }}</div>
        </div>
        <div class="flex justify-between py-2">
          <div class="">@lang('Shipping')</div>
          <div class="">{{ money($cart->adjustments_total) }}</div>
        </div>
        <div class="flex justify-between py-2 border-t border-pearl-dark mb-4">
          <div class="">@lang('Total')</div>
          <div class="">{{ money($cart->total) }}</div>
        </div>
        {{-- TODO: route checkout l10n --}}
        <a
          href="{{ route_l10n('checkout') }}"
          class="block w-full mb-2 py-2 pt-3 bg-blue font-display text-white text-lg text-center leading-none hover:bg-gray-900 transition-colors duration-300"
        >@lang('Checkout')</a>
        <button
          x-on:click="open = false"
          class="mx-auto block text-sm underline"
        >@lang('Continue Shopping')</button>
      </div>

      @endif
    </div>
  </x-ecommerce::slide-over>
</div>
