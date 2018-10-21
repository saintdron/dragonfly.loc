<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DragonFly</title>

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/bootstrap.min.css"/>

    <!-- Fonts -->
    {{--<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">--}}
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">

    <style>
        /*html, body {*/
        /*background-color: #fff;*/
        /*color: #636b6f;*/
        /*font-family: 'Raleway', sans-serif;*/
        /*font-weight: 100;*/
        /*height: 100vh;*/
        /*margin: 0;*/
        /*}*/

        /*.full-height {*/
        /*height: 100vh;*/
        /*}*/

        /*.flex-center {*/
        /*align-items: center;*/
        /*display: flex;*/
        /*justify-content: center;*/
        /*}*/

        /*.position-ref {*/
        /*position: relative;*/
        /*}*/

        /*.top-right {*/
        /*position: absolute;*/
        /*right: 10px;*/
        /*top: 18px;*/
        /*}*/

        /*.content {*/
        /*text-align: center;*/
        /*}*/

        /*.title {*/
        /*font-size: 84px;*/
        /*}*/

        /*.links > a {*/
        /*color: #636b6f;*/
        /*padding: 0 25px;*/
        /*font-size: 12px;*/
        /*font-weight: 600;*/
        /*letter-spacing: .1rem;*/
        /*text-decoration: none;*/
        /*text-transform: uppercase;*/
        /*}*/

        /*.m-b-md {*/
        /*margin-bottom: 30px;*/
        /*}*/

        html {
            height: 100%;
            background: url(assets/images/gif/water2.gif) no-repeat;
            background-size: cover;
        }

        body {
            height: 100%;
            background: rgba(255, 255, 255, 0.6);
            overflow: hidden;
        }

        .header,
        .footer {
            text-align: center;
        }

        .header {
            padding-top: 33px;
        }

        .footer {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 82px;
        }

        /*
                .home .container-fluid {
                    width: 100%;
                    height: 100%;
                    position: fixed;
                    top: 0;
                    left: 0;
                    overflow: auto;
                }

                .lily {
                    position: absolute;
                    width: 430px;
                    height: 430px;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                }

                .lily_back,
                .lily_front {
                    margin: auto;
                }

                .lily_back img,
                .lily_front img {
                    display: block;
                    margin: auto;
                }*/

        .navigation {
            display: flex;
            align-items: center;
            align-content: center;
            justify-content: center;
            overflow: auto;
            width: 560px;
            height: 560px;
            position: absolute;
            top: 52%;
            left: 50%;
            margin: -280px 0 0 -280px;
        }

        .lily_back,
        .lily_front,
        .menu {
            position: absolute;
            top: 50%;
            left: 50%;
        }

        .lily_back,
        .lily_front {
            transform: translate(-50%, -50%);
            pointer-events: none;
        }

        .lily_back img,
        .lily_front img {
            display: block;
            margin: auto;
        }

        .menu {
            /*position: relative;*/
            width: 123px;
            height: 123px;
            background: #34b3a0;
            border: 3px solid white;
            transition: all 0.5s ease-out;
            cursor: pointer;
        }

        .menu_left-top {
            transform-origin: right bottom;
            transform: translate(-100%, -100%);
            border-radius: 0 50px 0 50px;
        }

        .menu_left-top:hover {
            transform: translate(-100%, -100%) scale(2, 2);
        }

        .menu_right-top {
            transform-origin: left bottom;
            transform: translate(0, -100%);
            border-radius: 50px 0 50px 0;
        }

        .menu_right-top:hover {
            transform: translate(0, -100%) scale(2, 2);
        }

        .menu_left-bottom {
            transform-origin: right top;
            transform: translate(-100%, 0);
            border-radius: 50px 0 50px 0;
        }

        .menu_left-bottom:hover {
            transform: translate(-100%, 0) scale(2, 2);
        }

        .menu_right-bottom {
            transform-origin: left top;
            border-radius: 0 50px 0 50px;
        }

        .menu_right-bottom:hover {
            transform: scale(2, 2);
        }

        .menu_left-top-content {
            position: absolute;
            width: 280px;
            height: 280px;
            top: 0;
            left: 0;
        }

        .menu_left-top-content img {
            position: absolute;
            right: 50px;
            bottom: 50px;
        }

        .menu:hover {
            /*transform: translate(-100%, -100%) scale(2, 2);*/
            /*width: 280px;*/
            /*height: 280px;*/
        }


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
        <div class="menu_left-top-content">
            <img src="{{ asset('assets') }}/css/icons/web-design_green.png">
        </div>
        <div class="menu menu_right-top">
            <img src="{{ asset('assets') }}/css/icons/graphic-design_green.png">
        </div>
        <div class="menu menu_left-bottom">
            <img src="{{ asset('assets') }}/css/icons/skills_green.png">
        </div>
        <div class="menu menu_right-bottom">
            <img src="{{ asset('assets') }}/css/icons/cv_green.png">
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
