<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <!-- # Main Style Sheet -->
        <link rel="stylesheet" href="{{asset('front/css/style.css')}}">
        @livewireStyles
    </head>
    <body class="antialiased">
   

        <div class="container">

            @livewire('registration-form')

        </div>

        @livewireScripts
    </body>
</html>
