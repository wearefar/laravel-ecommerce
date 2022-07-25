<x-ecommerce::app-layout :title="__('Checkout')">
  <x-ecommerce::checkout.header />

  <div
    x-data="{ step: 1 }"
    x-on:step-updated.window="step = $event.detail.step"
    class="lg:h-screen pt-16 -mt-16 px-4 lg:px-0"
  >
    <div x-show="step != 4" class="lg:flex h-full">
      <x-ecommerce::checkout.panel step="1" :title="__('Shipping Address')" >
        <livewire:checkout-shipping />
        <x-slot name="button">
          <div :class="[ step == 1 ? 'block' : 'hidden' ]">
            <button class="block w-full py-3 border border-black bg-black text-white text-sm font-semibold" type="submit" form="shipping-form">@lang('Next')</button>
          </div>
          <div x-on:click="step = 1; $dispatch('step-updated', { step: 1 })" :class="[ step == 1 ? 'hidden' : 'block' ]" x-cloak>
            <button
              class="block w-full py-3 border border-black text-black text-sm font-semibold "
            >@lang('Edit')</button>
          </div>
        </x-slot>
      </x-ecommerce::checkout.panel>

      <x-ecommerce::checkout.panel step="2" :title="__('Payment Method')">
        <x-ecommerce::checkout.payment :order="$order" />
        <x-slot name="button">
          <div :class="[ step == 2 ? 'block' : 'hidden' ]" x-cloak>
            <button class="block w-full py-3 border border-black bg-black text-white text-sm font-semibold" id="validate-card">@lang('Next')</button>
          </div>
          <div x-on:click="step = 2; $dispatch('step-updated', { step: 2 })" :class="[ step == 3 ? 'block' : 'hidden' ]" x-cloak>
            <button
              class="block w-full py-3 border border-black text-black text-sm font-semibold "
            >@lang('Edit')</button>
          </div>
        </x-slot>
      </x-ecommerce::checkout.panel>

      <x-ecommerce::checkout.panel step="3" :title="__('Confirm Order')" >
        <livewire:checkout-review :order="$order" />
        <x-slot name="button">
          <div :class="[ step == 3 ? 'block' : 'hidden' ]" x-cloak>
            <button class="block w-full py-3 border border-black bg-black text-white text-sm font-semibold" type="submit" id="place-order">@lang('Place Order')</button>
          </div>
        </x-slot>
      </x-ecommerce::checkout.panel>
    </div>
    <div x-show="step == 4" class="h-full flex items-center justify-center">
      <div class="max-w-lg p-6 text-center text-sm sm:text-base">
        <h1 class="font-serif text-3xl sm:text-4xl mb-4">@lang('Thank you for your order')</h1>
        <p class="mb-4">@lang("We just sent you an email with your order details. Please be aware that the email might take a while to hit your inbox in some cases. If you don't receive the email, please make sure it didn't end up in spam folder.")</p>
        <p>@lang("If you need further assistance please contact us at :email and we'll gladly help you.", ['email' => sprintf('<a href="mailto:%1$s" class="underline">%1$s</a>', config('ecommerce.admin_email')[0])])</p>
      </div>
    </div>
  </div>
</x-ecommerce::app-layout>
