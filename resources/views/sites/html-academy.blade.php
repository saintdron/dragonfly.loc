@extends('sites.sites')

@section('site-content')
    <div class="site-row">
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/keksby.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
        <div class="work-desc">
            <p>Хочу сразу обратить внимание на то, что я не являюсь автором этих двух сайтов. Они были для меня лишь
                тренировочной площадкой (HTML + CSS).</p>
        </div>
    </div>

    <div class="site-row reverse">
        <div class="work-desc wow slideInLeft">
            <p>Задача была следующая: по образцу и предоставленным материалам необходимо было собрать эти сайты.
                Задача была выполнена, опыт получен, о чем и свидетельствуют эти превью.</p>
        </div>
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/kvast.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
    </div>
@endsection