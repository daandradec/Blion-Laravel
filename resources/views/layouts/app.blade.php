<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/classes.css')}}" rel="stylesheet">

    <style>
        body, html{
            width:100% !important;
            height:100% !important;
        }
        .error{
            color: #FF1111;
        }
    </style>
</head>
<body>

    <main class="py-4 w-100 h-100">
        @yield('content')
    </main>

</body>
</html>