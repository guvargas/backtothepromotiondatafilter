<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical', Request::url())"/>

    <meta property="og:description" content="@yield('description')">
    <meta property="og:title" content="@yield('title')@yield('title-end', ' | '.config('app.name'))">
    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="{{app()->getLocale()}}">
    <meta property="og:site_name" content=""/>
    <meta property="og:image" content="/@yield('image', 'img/share.png')"/>
    <meta property="og:image:url" content="{{ asset('/') }}@yield('image', 'img/share.png')">
    <meta property="og:image:size" content="300">

    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:image:src" content="{{ asset('/') }}@yield('image', 'img/share.png')">
    <meta name="twitter:title" content="@yield('title')@yield('title-end', ' | '.config('app.name'))">
    <meta name="twitter:site" content="">

    <title>@yield('title')@yield('title-end', ' | '.config('app.name'))</title>
    <meta name="description" content="@yield('description')">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <meta name="theme-color" content="{{ config('laravelpwa.manifest.theme_color') }}">

    <link rel="icon" sizes="512x512" href="{{ asset('img/pwa/icon-512x512.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/pwa/icon-512x512.png') }}">

    @yield('style')
    @yield('head')
</head>
<body>
    @yield('content')

    @yield('foot')
    @yield('script')

    <div class="text-center pb-5">
        <p class="mb-0">{{ config('app.name', 'Badmint') }} © {{Date('Y')}} - Todos os direitos reservados.</p>
        <a href="{{ route('login') }}">Administração</a>
    </div>

</body>
</html>
