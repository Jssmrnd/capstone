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
    <title>Document</title>
    @vite('resources/css/app.css')
</head>
<body>

<x-filament-fabricator::layouts.base :title="$page->title">
    {{-- Header Here --}}

<x-filament-fabricator::page-blocks :blocks="$page->blocks" />

     {{-- Footer Here --}}
</x-filament-fabricator::layouts.base>
    
</body>
</html>