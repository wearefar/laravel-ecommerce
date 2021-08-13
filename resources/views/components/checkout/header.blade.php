<div class="relative flex justify-center items-center h-12 md:h-16 bg-gray-200">
  <div class="absolute inset-y-0 left-0 ml-4 md:ml-12 flex items-center">
    <a href="{{ url()->previous() }}" class="font-semibold text-sm text-primary">
      <span>&larr;</span>
      <span class="hidden md:inline">@lang('Back to Shop')</span>
      <span class="md:hidden">@lang('Back')</span>
    </a>
  </div>
  <a href="{{ route_l10n('home') }}" title="@lang('Home')">
    <x-ecommerce::application-logo class="h-8 lg:h-10 w-auto" />
  </a>
</div>
