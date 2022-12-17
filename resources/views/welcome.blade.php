<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>C.G.H</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

        <!-- Styles -->


        <link href="{{ asset('css/welcome.blade.css') }}" rel="stylesheet">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="header">

        </div>
        <div class="introduction-block">
            <div class="introduction-block-inside">
                <h1>C.G.H</h1>
                <h1>CONTROL DE GUARDIAS HOSPITALARIAS</h1>
                        <a href="{{ route('login') }}" class="introduction-block-first-button">INICIAR SESIÓN</a>
            </div>
        </div>
    </body>
</html>
