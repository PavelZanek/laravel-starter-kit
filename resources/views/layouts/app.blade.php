<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}

    <title>@yield('pageTitle', (isset($header) ? strip_tags($header) : '')) | {{ config('app.name') }}</title>
    <meta name="robots" content="@yield('metaRobots', 'noindex, follow')">
    <meta name="description" content="@yield('metaDesc', '')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script>
        (function() {
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('headCode')
</head>
<body class="font-sans antialiased mx-auto bg-gray-100 dark:bg-gray-900 min-h-screen flex flex-col" style="max-width: 2400px;">
<x-banner />

<div class="bg-gray-100 dark:bg-gray-900 flex flex-col flex-grow">
    @livewire('layout.app-navigation')

    @include('layouts.inc.header')

    <main class="mt-auto pl-0 lg:pl-64 pt-12 flex-grow flex flex-col">
        @include('layouts.inc.breadcrumb')

        @include('layouts.inc.flash-messages')

        {{ $slot }}
    </main>

    <div class="pl-0 lg:pl-64">
        @include('layouts.inc.footer')
    </div>
</div>

@stack('modals')

@livewireScripts
</body>
</html>
