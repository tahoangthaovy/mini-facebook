<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MiniFacebook</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Style -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    {{--<link rel="stylesheet" type="text/css" href="/css/fontawesome.min.css">--}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/custom-style.css">
    <link rel="stylesheet" type="text/css" href="/css/custom-user-layout.css">
    <link rel="stylesheet" type="text/css" href="/css/notification.css">


    @stack('styles')


    <!-- Script -->
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/custom-script.js"></script>
    <script src="/js/custom-user.js"></script>
    <script src="/js/notification.js"></script>
    @stack('scripts')


</head>
<body>
@include('partial.chat-popup')
<div class="flex-center position-ref full-height">
    <nav class="navbar navbar-dark bg-primary topnav">
        <!-- Navbar content -->
        <div class="container">
            <ul>
                <li class="icon">
                    <a href="/">
                        {{--<img class="icon-image" src="/img/navbar-icon.png">--}}
                        <i class="fab fa-facebook-square"></i>
                    </a></li>
                <li>
                    <div class="search-container">
                        <form action="/" method="get">
                            <input type="text" placeholder="Search" name="q">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                </li>
                <li class="right"></li>
            </ul>
            <ul style="float: right;">
                <li class="user">
                    <a href="{{route('user-detail', ['id' => Auth::user()->id])}}">
                        <img class="user-image" src="{{Auth::user()->avatar}}">
                        <span class="nav-text">{{Auth::user()->name}}</span>
                    </a>
                </li>
                <li class="horizontal-hr"></li>
                <li class="user">
                    <a href="/">
                        <span class="nav-text">Home</span>
                    </a>
                </li>
                <li class="horizontal-hr" style="margin-left: 10px;margin-right: 10px;"></li>
                {{--<li class="icon user">--}}
                    {{--<div class="notification">--}}
                        {{--<a href="#">--}}
                            {{--<i class="fas fa-globe"></i>--}}
                        {{--</a>--}}
                        {{--<img class src="https://s3.amazonaws.com/codecademy-content/projects/2/feedster/bell.svg">--}}
                        {{--<ul class="notification-menu">--}}
                            {{--<li>--}}
                                {{--<img class="avatar" src="https://s3.amazonaws.com/codecademy-content/projects/2/feedster/wr2.svg">--}}
                                {{--<h3>William Roberts II</h3>--}}
                                {{--<p>Clean as a whistle</p>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<img class="avatar" src="https://s3.amazonaws.com/codecademy-content/projects/2/feedster/fn.svg">--}}
                                {{--<h3>Faheem Najm</h3>--}}
                                {{--<p>All I do is win</p>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</li>--}}
                {{--<li class="horizontal-hr" style="margin-left: 10px;margin-right: 10px;"></li>--}}
                <li class="icon user">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i style="line-height: 26px;" class="fas fa-sign-out-alt"></i>
                        <p style="font-size: 14px; float:right; margin: 0; font-weight: 600; padding-left: 5px;">Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>

            </ul>


        </div>
    </nav>

    <p class="friend-panel-collapse" data-toggle="collapse" data-target="#friend-panel" aria-expanded="false">Hide Panel</p>

    <div id="friend-panel" class="friend-panel collapse show">
        <p class="panel-title">Friend Panel</p>
        <p class="list-title">CONTACTS</p>
        <ul class="panel-list">
            @yield('contacts')
        </ul>
        <p class="list-title">GROUP CONVERSATIONS</p>
        <p class="list-title add-group" data-toggle="modal" data-target="#add-group-modal">+ Add Group</p>
        <ul class="panel-list">
            @yield('groups')
        </ul>
        <div class="search-contact">

        </div>
    </div>
    @section('sidebar')
        {{--This is the master sidebar.--}}
    @show


    @include('partial.create-group')


    <div class="newfeed-wrapper">
        @yield('profile-images')
        <div class="newfeed">
            @yield('content')
        </div>
    </div>



</div>
</body>
</html>
