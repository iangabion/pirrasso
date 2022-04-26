<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Pirasso</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="icon" type="image/png"  href="{{asset('images/qonvex_buy_sell.png')}}">

    </head>
    <body>
        <div id="app">
            <App/>
        </div>

        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
