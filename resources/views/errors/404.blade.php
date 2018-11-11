<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>DragonFly</title>

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/errors.css"/>

    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&amp;subset=cyrillic-ext" rel="stylesheet">
    <style>
        html {
            height: 100%;
        }

        body {
            height: 100%;
        }
    </style>
</head>
<body>
<div class="container-fluid error error-404">
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
