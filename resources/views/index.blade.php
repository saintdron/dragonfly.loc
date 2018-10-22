<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DragonFly</title>

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/home.css"/>

    <!-- Fonts -->
    {{--<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">--}}
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">

    <style>


    </style>
    <!-- Styles -->
</head>
<body class="home">
<div class="container-fluid">
    <div class="header">
        <img src="{{ asset('assets') }}/images/brand/logo.png">
    </div>
    <div class="footer">
        <img src="{{ asset('assets') }}/images/brand/compiled.png">
    </div>
    <div class="navigation">
        <div class="lily_back">
            <img src="{{ asset('assets') }}/images/water_lily_back.png">
        </div>
        <div class="menu menu_left-top"></div>
        <div class="menu menu_right-top"></div>
        <div class="menu menu_left-bottom"></div>
        <div class="menu menu_right-bottom"></div>
        <div class="menu-content">
            <div class="menu-content_left-top">
                {{--<img src="{{ asset('assets') }}/css/icons/web-design_green.png">--}}
            </div>
            <div class="menu-content_right-top"></div>
            <div class="menu-content_left-bottom"></div>
            <div class="menu-content_right-bottom"></div>
            {{--<div class="menu-content_right-top">--}}
                {{--<img src="{{ asset('assets') }}/css/icons/graphic-design_green.png">--}}
            {{--</div>--}}
            {{--<div class="menu-content_left-bottom">--}}
                {{--<img src="{{ asset('assets') }}/css/icons/skills_green.png">--}}
            {{--</div>--}}
            {{--<div class="menu-content_right-bottom">--}}
                {{--<img src="{{ asset('assets') }}/css/icons/cv_green.png">--}}
            {{--</div>--}}
        </div>
        <div class="lily_front">
            <img src="{{ asset('assets') }}/images/water_lily_front.png">
        </div>
    </div>

</div>
{{--<div class="flex-center position-ref full-height">--}}
{{--@if (Route::has('login'))--}}
{{--<div class="top-right links">--}}
{{--@auth--}}
{{--<a href="{{ url('/home') }}">Home</a>--}}
{{--@else--}}
{{--<a href="{{ route('login') }}">Login</a>--}}
{{--<a href="{{ route('register') }}">Register</a>--}}
{{--@endauth--}}
{{--</div>--}}
{{--@endif--}}

{{--<div class="content">--}}
{{--<div class="title m-b-md">--}}
{{--Laravel--}}
{{--</div>--}}

{{--<div class="links">--}}
{{--<a href="https://laravel.com/docs">Documentation</a>--}}
{{--<a href="https://laracasts.com">Laracasts</a>--}}
{{--<a href="https://laravel-news.com">News</a>--}}
{{--<a href="https://forge.laravel.com">Forge</a>--}}
{{--<a href="https://github.com/laravel/laravel">GitHub</a>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
<script type="text/javascript" src="{{ asset('assets') }}/js/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/js/menu.js"></script>
</body>
</html>
