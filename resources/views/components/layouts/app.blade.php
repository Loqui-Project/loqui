<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    darkMode: localStorage.getItem('darkMode') ||
        localStorage.setItem('darkMode', 'system')
}" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
    x-bind:class="{
        'dark': darkMode === 'dark' || (darkMode === 'system' && window.matchMedia('(prefers-color-scheme: dark)')
            .matches)
    }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') - Loqui</title>
    <meta name="description" content="Loqui: Send messages anonymously. Connect with others while protecting your identity. Simple, secure messaging."/>
    <meta name="robots" content="noindex,nofollow"/>
    <meta property="og:image" content="{{ URL::asset("default-image.png") }}" />
    @livewireStyles
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-black">
    <x-header />
    @yield('content')
    @livewireScripts
    @stack('scripts')
</body>

</html>
