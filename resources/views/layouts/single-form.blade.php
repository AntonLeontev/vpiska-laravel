<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <title>@yield('title') | {{ config('app.name', 'vpiska') }}</title>

        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="wrapper">
            <div class="content">
                <div class="wrapper-center">
                    <a href="{{route('home')}}">
                        <img class="" src="{{Vite::image('logo.png')}}" alt="logo" width="200px">
                    </a>
                    @yield('content')
                </div>
            </div>    
        </div>
    </body>
</html>
