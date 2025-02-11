<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite('resources/css/app.css')
        {{-- <link href="resources/css/app.css" rel="stylesheet"> --}}

    </head>
    <body class="antialiased">
        <h1 class="text-2xl font-bold text-cyan-500 pt-2 p-4">Welcomme to Laravel !</h1>
    </body>
</html>
