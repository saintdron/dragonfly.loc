<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="{{ (isset($meta_desc)) ? $meta_desc : '' }}">
    <meta name="keywords" content="{{ (isset($keywords)) ? $keywords : '' }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DragonFly</title>

    <!-- Style -->
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/index.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/animate.min.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/navigation.css"/>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&amp;subset=cyrillic-ext" rel="stylesheet">
</head>
<body class="home">
<div class="container-fluid">
    <div class="header">
        <img src="{{ asset('assets') }}/images/brand/logo.png">
    </div>
    <div class="footer">
        <img src="{{ asset('assets') }}/images/brand/compiled.png">
    </div>
</div>

<!-- Navigation -->
@yield('navigation')

<!-- Script -->
<script type="text/javascript" src="{{ asset('assets') }}/js/jquery.min.js"></script>
{{--<script type="text/javascript" src="{{ asset('assets') }}/js/bootstrap.min.js"></script>--}}
<script type="text/javascript" src="{{ asset('assets') }}/js/menu.js"></script>
</body>
</html>
