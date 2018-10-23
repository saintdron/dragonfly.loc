<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DragonFly</title>

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/home.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/navigation.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/animate.min.css"/>

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
    <div class="navigation">
        <div class="lily_back">
            <img src="{{ asset('assets') }}/images/water_lily_back.png">
        </div>
        <div class="menu menu_left-top"></div>
        <div class="menu menu_right-top"></div>
        <div class="menu menu_left-bottom"></div>
        <div class="menu menu_right-bottom"></div>
        <div class="menu-content">
            <div class="menu-content_left-top" {{--style="background: red;"--}}>
                <h2 class="animated fadeInDown faster" style="display: none;">Веб-дизайн и&nbsp;разработка</h2>
                <p style="display: none;">
                    <span class="animated fadeInLeftBig faster">Готовые сайты,</span><br>
                    <span class="animated fadeInLeftBig faster">онлайн утилиты,</span><br/>
                    <span class="animated fadeInLeftBig faster">JS- и CSS-анимации</span>
                </p>
            </div>
            <div class="menu-content_right-top">
                <h2 class="animated fadeInDown faster" style="display: none;">Графический дизайн</h2>
                <p style="display: none;">
                    <span class="animated fadeInRightBig faster">Брендирование,</span><br>
                    <span class="animated fadeInRightBig faster">полиграфическая продукция,</span><br/>
                    <span class="animated fadeInRightBig faster">видео и gif-анимации</span>
                </p>
            </div>
            <div class="menu-content_left-bottom">
                <h2 class="animated fadeInUp faster" style="display: none;">Навыки</h2>
                <p style="display: none;">
                    <span class="animated fadeInLeftBig faster">Квалификация в&nbsp;области программирования</span>
                </p>
            </div>
            <div class="menu-content_right-bottom">
                <h2 class="animated fadeInUp faster" style="display: none;">Обо мне</h2>
                <p style="display: none;">
                    <span class="animated fadeInRightBig faster">Контактная информация,</span><br>
                    <span class="animated fadeInRightBig faster">резюме</span>
                </p>
            </div>
        </div>
        <div class="lily_front">
            <img src="{{ asset('assets') }}/images/water_lily_front.png">
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('assets') }}/js/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/js/menu.js"></script>
</body>
</html>
