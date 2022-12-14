<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @auth
            <meta name="user_id" content="{{ auth()->id() }}">
        @endauth
        <link rel="icon" href="{{ asset('favicon.ico') }}"  type='image/x-icon'>


        <title>@yield('title') | {{ config('app.name', 'vpiska') }}</title>

        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @yield('page-scripts')
    </head>
    <body>
        <div class="wrapper">
            @include('partials.header')
            @yield('content')
            @include('partials.footer')
        </div>
    </body>
</html>
