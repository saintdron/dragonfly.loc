@extends('sites.sites')

@section('site-content')
    <div class="site-row">
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/home.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
        <div class="work-desc">
            <p>Один из моих первых сайтов. Выполнен на базе CMS Joomla. Сайт был сделан для редакции
                «Каталог К-Галерея», в которой я в то же время занимался дизайном и версткой каталогов.</p>
        </div>
        <img class="figure figure-rb wow flipInY" {{--data-wow-offset="200"--}}
        src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/figure1.png">
    </div>

    <div class="site-row reverse">
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/catalogs.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
        <div class="work-desc wow slideInLeft">
            <p>Редакция «Каталог К-Галерея» сотрудничает с художниками, а также прикладниками, мастерами
                кукол, скульпторами, архитекторами, дизайнерами интерьера и ландшафтными дизайнерами.</p>
        </div>
        <img class="figure figure-lb wow flipInY" {{--data-wow-offset="200"--}}
        src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/figure2.png">
    </div>

    <div class="site-row">
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/lightbox.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
        <div class="work-desc wow slideInRight">
            <p>Сайт содержал очень удобную и с приятной анимацией навигацию по каталогам, возможностью
                рассмотреть детально каждую из работ, а также видео-релизы с прошедших выставок.</p>
        </div>
    </div>
@endsection