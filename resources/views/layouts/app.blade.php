<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    <link rel="icon" href="{{ asset("images/favicon.svg") }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset("images/favicon-16.png") }}" type="image/png" sizes="16x16">
    <link rel="icon" href="{{ asset("images/favicon-32.png") }}" type="image/png" sizes="32x32">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @livewireStyles

    <style>[x-cloak] { display:none }</style>

    @yield('meta')

    {{-- TODO: fathom script --}}
    @production
      <script src="https://cdn.usefathom.com/script.js" data-site="ABCDEFG" defer></script>
    @endproduction
  </head>
  <body class="font-sans font-normal text-base bg-gray-200 antialiased">

    {{ $slot }}

    @livewireScripts

    @stack('scripts')

  </body>
</html>
