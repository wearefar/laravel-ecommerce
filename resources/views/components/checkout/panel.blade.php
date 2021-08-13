<div
  class="max-w-lg mx-auto lg:max-w-none lg:w-1/3 overflow-y-auto transition-colors duration-300 bg-gray-100 mb-4 lg:mb-0"
  :class="[step == {{ $step }} ? 'lg:bg-gray-200' : 'lg:bg-gray-100']"
>
  <div class="px-4 md:px-12 py-6 min-h-full flex flex-col justify-between">
    <div
      class="transition-opacity duration-300"
      :class="[step == {{ $step }} ? 'opacity-100' : 'opacity-50 pointer-events-none']"
    >
      <h1 class="mb-6">
        <span class="lg:flex lg:items-center lg:justify-center lg:rounded-full lg:border lg:border-black lg:w-6 lg:h-6 text-sm font-semibold lg:mx-auto lg:mb-4">{{ $step }}</span><span class="lg:hidden">.</span>
        <span class="lg:block lg:font-display font-semibold text-sm lg:text-3xl uppercase lg:normal-case lg:text-center">{{ $title }}</span>
      </h1>

      {{ $slot }}
    </div>

    {{ $button ?? null }}

  </div>
</div>
