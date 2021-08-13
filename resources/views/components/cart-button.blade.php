<button
  x-data="{ count: 0 }"
  x-on:update-cart-count.window="count = $event.detail.count"
  x-on:click="$dispatch('toggle-cart')"
  :aria-label="'@lang('Shopping Cart')'+` (${count})`"
  class="flex items-center"
>
  <x-ecommerce::icons.shopping-bag
    class="w-6 h-6 mr-2 hover:fill-blue-light transition-fill duration-150"
    role="presentation"
  />
  <span
    x-text="count"
    class="font-display font-display leading-none -mb-1"
    aria-hidden="true"
  ></span>
</button>
