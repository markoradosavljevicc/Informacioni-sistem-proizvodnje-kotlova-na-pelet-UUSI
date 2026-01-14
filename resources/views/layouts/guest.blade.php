<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="color: #000000;">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-red-50 to-white">
            <div class="mb-6">
                <a href="{{ route('welcome') }}" class="flex items-center space-x-2 hover:opacity-80 transition">
                    <span class="text-3xl font-bold text-red-600">MARELLI</span>
                    <span class="text-2xl font-semibold text-gray-800">KOTLOVI</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white shadow-xl overflow-hidden sm:rounded-lg border border-gray-200">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
