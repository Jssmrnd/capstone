@props(['page'])
{{-- <x-filament-fabricator::layouts.base :title="$page->title">

    <x-filament-fabricator::page-blocks :blocks="$page->blocks" />

</x-filament-fabricator::layouts.base> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/own/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/own/style.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('css/own/product-page-specs.css') }}" /> --}}
    <title>Document</title>
    <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
  />
  <!-- Remix Icon CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css"
    rel="stylesheet"
  />
  <!-- Title -->
    {{-- @vite('resources/css/app.css') --}}
</head>
<body>
    <x-filament-fabricator::layouts.base :title="$page->title">
    {{-- Header Here --}}
 
    <x-filament-fabricator::page-blocks :blocks="$page->blocks" />
 
     {{-- Footer Here --}}
    </x-filament-fabricator::layouts.base>
    @filamentScripts
</body>
</html>
