<article class="border-t border-gray-200 py-4 flex items-center justify-between">
  <div class="w-20 h-20 md:w-24 md:h-24 mr-2 flex-shrink-0">
    <img src="{{ $item->thumbnail }}" alt="" class="w-full h-full object-contain">
  </div>
  <div class="flex-grow mr-4">
    <h1 class="font-semibold text-sm">{{ $item->name }}</h1>
    <div class="text-sm">{{ money($item->pivot->unit_price) }}</div>
    <button
      wire:click="remove({{ $item->id }})"
      class="text-xs font-semibold text-blue text-left mt-4"
    >@lang('Remove')</button>
  </div>
  <div class="flex flex-col items-center px-2">
    <button
      x-bind:class="{ 'pointer-events-none opacity-25': false }"
      wire:click="increment({{ $item->id }})"
      aria-label="@lang('Increment quantity')"
    ><x-ecommerce::icons.chevron-up class="w-4 h-4" role="presentation" /></button>
    <span class="text-sm font-semibold py-1">{{ $item->pivot->quantity }}</span>
    <button
      wire:click="decrement({{ $item->id }})"
      x-bind:class="{ 'pointer-events-none opacity-25': {{ $item->pivot->quantity == 1 ? 'true' : 'false' }} }"
      aria-label="@lang('Decrement quantity')"
    ><x-ecommerce::icons.chevron-down class="w-4 h-4" role="presentation" /></button>
  </div>
</article>
