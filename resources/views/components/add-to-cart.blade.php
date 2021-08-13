@props(['id'])
<div>
  <button
    x-data
    x-on:click="$dispatch('add-to-cart', { productId: {{ $id }}, quantity: 1 })"
    class="px-6 py-2 mr-1 font-semibold text-sm uppercase leading-none bg-gray-100 border border-gray-900 rounded-full hover:bg-gray-900 hover:text-gray-100 transition-colors duration-300"
  >@lang('Add to cart')</button>
</div>
