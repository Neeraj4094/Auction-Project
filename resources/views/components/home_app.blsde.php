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
    <body class="font-sans antialiased min-h-screen grid grid-cols-12 grid-rows-6">
        <!-- Page Aside -->
        <div class="">
            @include('layouts.home.header')
        </div>
        <!-- Page Content -->
        
        <main class="">
        @if(request()->session()->has('message'))
        <div class="flex items-center justify-center m-2">
            <div class="bg-green-50 text-green-600  w-60 p-2 rounded-lg">
                {{request()->session()->get('message')}}
            </div>
        </div>
        @endif
            {{ $slot }}
        </main>
    </body>
</html>
