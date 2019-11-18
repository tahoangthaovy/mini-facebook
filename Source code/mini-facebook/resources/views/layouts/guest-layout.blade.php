<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MiniFacebook</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Style -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    {{--<link rel="stylesheet" type="text/css" href="/css/fontawesome.min.css">--}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/custom-style.css">
    <link rel="stylesheet" type="text/css" href="/css/custom-guest-layout.css">


    @stack('styles')


<!-- Script -->
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/custom-script.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    @stack('scripts')


</head>
<body>
<div class="flex-center position-ref full-height">

    <nav class="navbar navbar-dark bg-primary topnav">
        <!-- Navbar content -->
        <div class="container">
            <div class="logo">
                <a href="/"><span class="mini">mini</span><img src="/img/facebook-text-white.png"></a>
            </div>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            </ul>
        </div>
    </nav>

    @section('sidebar')
        {{--This is the master sidebar.--}}
    @show

    {{--<div class="container" style="padding-top: 1.5em">--}}
        @yield('content')
    {{--</div>--}}


</div>
@include('partial.footer')
</body>
</html>
