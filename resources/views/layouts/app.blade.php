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
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">

    @yield('styles')
    
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

    <nav class="navbar-dark bg-dark" style="margin-bottom:50px;">
        <ul class="center list-inline w-100" style="height:70px;">
            <li class="mx-3">
                <a href="{{route('home')}}" style="font-size:18px;color:white;">HOME <i class="fas fa-home"></i></a>
            </li>
            <li class="mx-3">
                <a href="#" style="font-size:18px;color:white;">ALGO</a>
            </li>
            <li style="min-width:190px;height:100%;overflow:visible;">
                <a href="{{route('home')}}">
                    <img src="{{ asset('img/logo.png') }}" width="100%" height="120px">
                </a>
            </li>
            <li class="mx-3">
                <a href="#" style="font-size:18px;color:white;">ALGO</a>
            </li>
            <li class="mx-3 dropdown">
                <a href="#" style="font-size:18px;color:white;text-transform:uppercase;" class="dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }} <i class="fas fa-address-card"></i>
                </a>
                <div class="dropdown-menu my-2" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{route('user.show')}}">Mi Perfil <i class="fas fa-address-book"></i></a>
                    <a class="dropdown-item" href="{{route('user.contents')}}">Mis Contenidos <i class="far fa-folder-open"></i></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}">Desloguearse <i class="fas fa-sign-out-alt"></i></a>
                </div>
            </li>
        </ul>
    </nav>

    <main class="py-4 w-100">
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>