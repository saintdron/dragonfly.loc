<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DragonFly</title>

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/style.css"/>

    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&amp;subset=cyrillic-ext" rel="stylesheet">
    <style>
        .error-404 {
            display: flex;
            height: 100%;
            font-family: 'Roboto', sans-serif;
        }

        .error-404 .content {
            width: 66vw;
            margin: auto;
            text-align: center;
        }

        .error-404 .code {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 27vw;
            line-height: 27vw;
            font-family: 'Roboto Slab', serif;
            padding-bottom: 10px;
        }

        .error-404 .code__number {
            width: 25%;
            font-weight: bold;
            color: #cccccc;
            text-shadow: -0.4vw -0.4vw 0 white,
            0.4vw -0.4vw 0 white,
            -0.4vw 0.4vw 0 white,
            0.4vw 0.4vw 0 white,
            -0.46vw -0.46vw 0 #cccccc,
            0.46vw -0.46vw 0 #cccccc,
            -0.46vw 0.46vw 0 #cccccc,
            0.46vw 0.46vw 0 #cccccc;
        }

        .error-404 .code__image {
            display: inline-block;
            width: 50%;
            text-align: center;
        }

        .error-404 .code__image img {
            position: relative;
            bottom: 2.2vw;
            height: 21vw;
            border: 0.45vw solid white;
            box-shadow: 0 0 0 0.075vw #cccccc;
            border-radius: 10.5vw;
        }

        .error-404 p {
            color: #676767;
        }

        .error-404 a {
            background-color: #34b3a0;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .error-404 a:hover {
            background-color: #238576;
            border-color: #238273;
        }
    </style>
</head>
<body>
<div class="container-fluid error-404">
    <div class="content">
        <div class="code">
            <div class="code__number">4</div>
            <div class="code__image">
                <img src="{{ asset(config('settings.gif_dir')) . '/404.gif' }}">
            </div>
            <div class="code__number">4</div>
        </div>
        <p>Добыть указанную страницу не удастся –<br>она отсутствует на сайте.</p>
        <a href="{{ route('index') }}" role="button">Вернуться на главную</a>
    </div>
</div>
</body>
</html>
