<div x-cloak>
  <div
    class="fixed inset-y-0 right-0 w-full max-w-xl bg-white p-5 md:p-12 lg:p-16 z-40 shadow-xl"
    x-show="open"
    x-on:keydown.escape.window="open = false"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="transform translate-x-full"
    x-transition:enter-end="transform translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="transform translate-x-0"
    x-transition:leave-end="transform translate-x-full"
    role="dialog"
    aria-modal="true"
    aria-label="@lang('Shopping Cart')"
  >
    <button
      class="absolute top-0 right-0 mr-5 lg:mr-8 mt-5 lg:mt-8"
      @click="open = false"
      aria-label="@lang('Close')"
    ><x-ecommerce::icons.x class="w-6 h-6" role="presentation" /></button>

    <div class="h-full overflow-y-auto">
      {{ $slot }}
    </div>

  </div>
  <div
    class="fixed inset-0 bg-black bg-opacity-50 z-30"
    @click="open = false"
    x-show="open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    role="presentation"
  ></div>
</div>
