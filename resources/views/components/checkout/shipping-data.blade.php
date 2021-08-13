<div class="mb-6">
  <div class="font-semibold text-xs text-jade uppercase mb-2">@lang('Email')</div>
  <div id="customerEmail">{{ $email }}</div>
</div>
<div class="mb-6">
  <div class="font-semibold text-xs text-jade uppercase mb-2">@lang('Shipping Address')</div>
  <div id="customerName">{{ $name }}</div>
  <div id="customerAddressLine1">{{ $address_line_1 }}</div>
  <div>
    <span id="customerAddressZip">{{ $zip }}</span>
    <span id="customerAddressCity">{{ $city }}</span>,
    <span id="customerAddressState">{{ $state }}</span>
  </div>
  <div id="customerAddressCountry">{{ Symfony\Component\Intl\Countries::getName($country, app()->getLocale()) }}</div>
</div>
<div class="mb-6">
  <div class="font-semibold text-xs text-jade uppercase mb-2">@lang('Phone')</div>
  <div>{{ $phone }}</div>
</div>

<input type="hidden" id="clientSecret" value="{{ $client_secret }}">
