<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="{{ (isset($meta_desc)) ? $meta_desc : '' }}">
    <meta name="keywords" content="{{ (isset($keywords)) ? $keywords : '' }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title or 'DragonFly' }}</title>

    <!-- Style -->
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/extra/jquery-ui/jquery-ui.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/animate.min.css"/>
    <link rel="stylesheet" type="text/css" media="all"
          href="{{ asset('assets') }}/extra/fontawesome-free-5.4.1-web/css/all.css"/>
    <link rel="stylesheet" type="text/css" media="all"
          href="{{ asset('assets') }}/extra/lightbox2-master/dist/css/lightbox.min.css"/>
    <link rel="stylesheet" type="text/css" media="all"
          href="{{ asset('assets') }}/extra/rangeslider/rangeslider.css"/>
    <link rel="stylesheet" type="text/css" media="all"
          href="{{ asset('assets') }}/extra/switch/switch.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/style.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/errors.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/css/navigation.css"/>
    <link rel="stylesheet" type="text/css" media="all"
          href="{{ asset('assets') }}/extra/bootstrap-multiselect/css/bootstrap-multiselect.css"/>
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset('assets') }}/extra/summernote/summernote.css"/>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&amp;subset=cyrillic-ext" rel="stylesheet">
    {{--<link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700&amp;subset=cyrillic-ext"
          rel="stylesheet">--}}
    <link href="https://fonts.googleapis.com/css?family=Roboto:400i,500,500i,700&amp;subset=cyrillic-ext"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">
</head>
</body>
<!-- Content -->
<div id="content">
    @yield('content')
</div>
<!-- Navigation -->
@yield('navigation')
<!-- Script -->
<script type="text/javascript" src="{{ asset('assets') }}/js/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/extra/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/js/popper.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/extra/lightbox2-master/dist/js/lightbox.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/js/radialprogress.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/extra/rangeslider/rangeslider.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/extra/switch/switch.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/js/script.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/js/menu.js"></script>
{{--<script type="text/javascript" src="{{ asset('assets') }}/js/mail.js"></script>--}}
<script type="text/javascript" src="{{ asset('assets') }}/extra/jcprogress/jcprogress.js"></script>
{{--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/clipboard@1/dist/clipboard.min.js"></script>--}}
<script type="text/javascript" src="{{ asset('assets') }}/extra/clipboard/dist/clipboard.min.js"></script>
<script type="text/javascript"
        src="{{ asset('assets') }}/extra/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/extra/summernote/summernote.min.js"></script>
<script type="text/javascript" src="{{ asset('assets') }}/extra/summernote/lang/summernote-ru-RU.js"></script>
</body>
</html>
