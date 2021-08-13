<form wire:submit.prevent="submit" id="shipping-form">
  {{-- Email --}}
  <div class="mb-4">
    <x-ecommerce::label for="email" value="{{ __('Email') }}" />
    <x-ecommerce::input id="email" type="email" class="mt-1 block w-full" wire:model.defer="email" required autocomplete="email" />
    <x-ecommerce::input-error for="email" class="mt-2" />
  </div>

  {{-- Name --}}
  <div class="mb-4">
    <x-ecommerce::label for="name" value="{{ __('Name') }}" />
    <x-ecommerce::input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name" required autocomplete="name" />
    <x-ecommerce::input-error for="name" class="mt-2" />
  </div>

  {{-- Address --}}
  <div class="mb-4">
    <x-ecommerce::label for="address_line_1" value="{{ __('Address') }}" />
    <x-ecommerce::input id="address_line_1" type="text" class="mt-1 block w-full" wire:model.defer="address_line_1" required autocomplete="shipping street-address" />
    <x-ecommerce::input-error for="address_line_1" class="mt-2" />
  </div>

  <div class="flex space-x-4 mb-4">
    {{-- Postal Code --}}
    <div class="w-1/2">
      <x-ecommerce::label for="zip" value="{{ __('Postal Code') }}" />
      <x-ecommerce::input id="zip" type="text" class="mt-1 block w-full" wire:model.defer="zip" required autocomplete="shipping postal-code" />
      <x-ecommerce::input-error for="zip" class="mt-2" />
    </div>

    {{-- City --}}
    <div class="w-1/2">
      <x-ecommerce::label for="city" value="{{ __('City') }}" />
      <x-ecommerce::input id="city" type="text" class="mt-1 block w-full" wire:model.defer="city" required autocomplete="shipping address-level2" />
      <x-ecommerce::input-error for="city" class="mt-2" />
    </div>
  </div>


  <div class="flex space-x-4 mb-4" x-data="{ country: null }">
    {{-- Country --}}
    <div class="w-1/2">
      <x-ecommerce::label for="country" value="{{ __('Country') }}" />
      <x-ecommerce::select id="country" class="mt-1 block w-full" wire:model.defer="country" required autocomplete="shipping country" :options="config('ecommerce.countries')" />
      <x-ecommerce::input-error for="country" class="mt-2" />
    </div>

    {{-- State/Province --}}
    <div class="w-1/2">
      <x-ecommerce::label for="state" value="{{ __('State/Province') }}" />
      <x-ecommerce::input id="state" type="text" class="mt-1 block w-full" wire:model.defer="state" required autocomplete="shipping address-level1" />
      <x-ecommerce::input-error for="state" class="mt-2" />
    </div>
  </div>

  {{-- Phone --}}
  <div class="mb-4">
    <x-ecommerce::label for="phone" value="{{ __('Phone') }}" />
    <x-ecommerce::input id="phone" type="text" class="mt-1 block w-full" wire:model.defer="phone" required autocomplete="tel" />
    <x-ecommerce::input-error for="phone" class="mt-2" />
  </div>
</form>
