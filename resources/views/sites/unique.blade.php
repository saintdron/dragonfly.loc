@extends('sites.sites')

@section('site-content')
    <div class="site-row">
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/UNIQUE_1.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
        <div class="work-desc">
            <p>Сайт был создан по материалам видео-урока «Laravel framework. Zero to Pro». Мало отличается от финальной
                версии самого урока, но все же, как возможность сделать что-либо подобное, не мог не
                продемонстрировать.</p>
        </div>
    </div>

    <div class="site-row reverse">
        <div class="work-desc wow slideInLeft">
            <p>Характерен удобным перемещением по разделам, свойственным веб-страницам формата landing-page, и ненавязчивой,
                мягкой анимацией.</p>
        </div>
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/UNIQUE_2.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
    </div>
@endsection