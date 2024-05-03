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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="author" content="Loqui" />
    <meta name="google" content="notranslate" data-rh="true" />
    <meta name="robots" content="index, follow" data-rh="true" />
    <meta name="description"
        content="Loqui: Send messages anonymously. Connect with others while protecting your identity. Simple, secure messaging."
        data-rh="true" />
    <meta name="applicable-device" content="pc, mobile" data-rh="true" />
    <meta name="canonical" content="{{ URL::current() }}" data-rh="true" />
    <meta name="keywords"
        content="Loqui, loqui, links, link, cv, portfolio, aggregation, platform, social, media, profile, bio, tree"
        data-rh="true" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-title" content="Loqui" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />

    <link rel="shortcut icon" href="{{ URL::asset('/images/logo.svg') }}" type="image/x-icon" />
    <link rel="manifest" href="/manifest.json" />

    <meta name="theme-color" content="#000000" />

    <meta content="Loqui" property="og:site_name" />
    <meta property="og:url" content="{{ URL::current() }}" data-rh="true" />


    <title>@yield('title') / Loqui</title>
    <meta property="og:type" content="profile" data-rh="true" />
    @if (Auth::check())
        <meta property="profile:username" content="{{ Auth::user()->username }}" data-rh="true" />
        <meta property="og:image" content="{{ URL::asset(Auth::user()->mediaObject->media_path) }}" data-rh="true" />
    @else
        <meta property="og:image" content="{{ URL::asset('/images/logo.svg') }}" data-rh="true" />
    @endif
    <meta property="og:title" content="@yield('title') / Loqui" data-rh="true" />
    <meta property="og:description"
        content="Send messages anonymously. Connect with others while protecting your identity. Simple, secure messaging."
        data-rh="true" />

    @livewireStyles
    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-black">
    @livewire('component.header')
    <main class="min-h-screen">
        @yield('content')
    </main>
    @livewire('layout.footer')

    @livewireScripts
    @stack('scripts')
</body>

</html>
