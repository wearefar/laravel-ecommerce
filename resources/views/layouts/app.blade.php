<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    <link rel="icon" href="{{ asset("images/favicon.svg") }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset("images/favicon-16.png") }}" type="image/png" sizes="16x16">
    <link rel="icon" href="{{ asset("images/favicon-32.png") }}" type="image/png" sizes="32x32">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">

    @livewireStyles

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

    <style>[x-cloak] { display:none }</style>

    @yield('meta')

    {{-- TODO: fathom script --}}
    @production
      <script src="https://sloth.vguerrerobosch.com/script.js" data-site="EFIXZBWP" defer></script>
    @endproduction
  </head>
  <body class="font-sans font-normal text-base bg-gray-200 antialiased">

    {{ $slot }}

    @livewireScripts

    @stack('scripts')

  </body>
</html>
