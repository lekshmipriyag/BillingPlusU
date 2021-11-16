<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>BillingPlusU | @yield('title')</title>
        <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('images/logo-favicon-32x32.png') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/circular-std/style.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/fonts/fontawesome/css/fontawesome-all.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
        <style>
            html,
            body {
                height: 100%;
                background-image:url("{{ URL::asset('images/Billingplus-homescreen-500x500.png') }}");
            }
        </style>
        @yield('head')
    </head>
    <body>
        @section('body')
        @show
        <script src="{{ URL::asset('js/jquery/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ URL::asset('js/bootstrap/bootstrap.bundle.js') }}"></script>
        @yield('foot')
    </body>
</html>
