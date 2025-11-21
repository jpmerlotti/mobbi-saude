<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title . " | " . config('app.name') ?? config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    @filamentStyles()
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-gray-800 bg-neutral-100">


    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        {{ $slot }}
    </div>

    @livewire('notifications')

    @filamentScripts
    @vite('resources/js/app.js')
</body>
</html>
