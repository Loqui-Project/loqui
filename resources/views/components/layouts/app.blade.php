@use('App\Models\User')
@php
$user = User::where('id', Auth::id())->first();
$lang = str_replace('_', '-', app()->getLocale());
$dir = $lang === 'ar' ? 'rtl' : 'ltr';
@endphp
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $dir }}" class="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="author" content="Loqui" />
    <meta name="google" content="notranslate" data-rh="true" />
    <meta name="robots" content="index, follow" data-rh="true" />
    <meta name="description" content="Loqui: Send messages anonymously. Connect with others while protecting your identity. Simple, secure messaging." data-rh="true" />
    <meta name="applicable-device" content="pc, mobile" data-rh="true" />
    <meta name="canonical" content="{{ URL::current() }}" data-rh="true" />
    <meta name="keywords" content="Loqui, loqui, links, link, cv, portfolio, aggregation, platform, social, media, profile, bio, tree" data-rh="true" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-title" content="Loqui" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />

    <link rel="shortcut icon" href="{{ URL::asset('/images/logo.svg') }}" type="image/x-icon" />
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#000000" />

    <meta content="Loqui" property="og:site_name" />
    <meta property="og:url" content="{{ URL::current() }}" data-rh="true" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{__($title)}} / Loqui</title>
    <meta property="og:type" content="profile" data-rh="true" />
    @if ($user)
    <meta property="profile:username" content="{{ $user->username }}" data-rh="true" />
    <meta property="og:image" content="{{ URL::asset($user->image_url) }}" data-rh="true" />
    @else
    <meta property="og:image" content="{{ URL::asset('/images/logo.svg') }}" data-rh="true" />
    @endif
    <meta property="og:title" content="{{__($title)}} / Loqui" data-rh="true" />
    <meta property="og:description" content="Send messages anonymously. Connect with others while protecting your identity. Simple, secure messaging." data-rh="true" />

    @filamentStyles
    @stack('styles')
    @vite('resources/css/app.css')
</head>


<body class="bg-white dark:bg-black test" x-data="{ 'isModalOpen': false }"  x-on:keydown.escape="isModalOpen = false">
    @livewire('layout.header', ['user' => $user])
        <div id="myButton">Send notifications</div>
        <main class="min-h-screen">
        {{$slot}}
    </main>
    @livewire('layout.footer')
    @stack('extend-component')
    @filamentScripts

    @vite('resources/js/app.js')
    @stack('scripts')
    <script>
        window.Laravel = {
            "csrfToken" :  document.querySelector('meta[name="csrf-token"]').attributes["content"].value,
            "baseUrl" : "{{ URL::to('/') }}",
            "user" : @json([
                'id' => $user->id,
                'username' => $user->username,
            ])
        };
        document.getElementById('myButton').addEventListener('click', function() {
  // Check if push notifications are supported and allowed
  if (navigator.serviceWorker && window.PushManager && window.Notification) {
    // Request permission to send push notifications
    navigator.serviceWorker.getRegistration().then(function(registration) {
      registration.pushManager.subscribe({ userVisibleOnly: true }).then(function(subscription) {
        console.log('Push notifications are allowed.');
        //save the push subscription in your database
      }).catch(function(error) {
        console.log('Error:', error);
      });
    });
  }
});
    </script>
</body>

</html>