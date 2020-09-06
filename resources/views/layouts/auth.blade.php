<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="Content-Language" content="en" />
        <meta name="msapplication-TileColor" content="#2d89ef">
        <meta name="theme-color" content="#4188c9">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        <!--[if lt IE 9]>
            <script src="{{ asset('/js/vendors/reshtml5shivpond.min.js') }}"></script>
            <script src="{{ asset('/js/vendors/respond.min.js') }}"></script>
        <![endif]-->
        <link rel="stylesheet" href="{{ asset('/vendors/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/fonts.css') }}">
        <script src="{{ asset('/js/require.min.js') }}"></script>
        <script>
            requirejs.config({
                baseUrl: '{{ config('app.asset_url') }}'
            });
        </script>
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />
        <script src="{{ asset('/js/app.js') }}"></script>
    </head>
    <body>
        <div class="page">
            @yield('content')
        </div>
    </body>
</html>
