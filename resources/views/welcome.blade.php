<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        
    </head>
    <body class="antialiased">
        vpiska

        <div class="wrap">
            <div class="carousel">slide1</div>
            <div class="carousel">slide2</div>
            <div class="carousel">slide3</div>
        </div>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        
    </body>
</html>
