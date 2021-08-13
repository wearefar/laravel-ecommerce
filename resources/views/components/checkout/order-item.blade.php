<article class="py-4 flex justify-between">
  <div class="w-20 h-20 md:w-24 md:h-24 mr-2">
    <img src="{{ $item->thumbnail }}" alt="" class="w-full h-full object-contain">
  </div>
  <div class="flex-grow mr-4">
    <h1 class="font-semibold text-sm">{{ $item->name }}</h1>
    <div class="text-xs">{{ $item->pivot->quantity }} &times; {{ money($item->pivot->unit_price) }}</div>
  </div>
  <span class="text-sm">{{ money($item->pivot->total) }}</span>
</article>
