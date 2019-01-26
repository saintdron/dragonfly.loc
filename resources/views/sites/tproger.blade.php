@extends('sites.sites')

@section('site-content')
    <div class="site-row">
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/Tproger_1.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
        <div class="work-desc">
            <p>Пример выполненного корпоративного сайта. На нем присутствуют классические для подобного портала блоки:
                новости, комментарии к ним, раздел с работами, контактная информация и форма обратной связи. Информацию
                для заполнения брал с известного одноименного портала.</p>
        </div>
    </div>

    <div class="site-row reverse">
        <div class="work-desc" style="opacity: 0;"></div>
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/Tproger_2.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
    </div>

    <div class="site-row">
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/Tproger_3.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
        <div class="work-desc wow slideInRight">
            <p>Фундаментом для сайта послужил пройденный видео-курс, но многие элементы были переделаны, а некоторые и вовсе отсутствовали
                в исходнике. Верстка адаптивная (мобильная), как впрочем и на всех остальных сайтах, выполненных
                мной.</p>
        </div>
    </div>

    <div class="site-row reverse">
        <div class="work-desc" style="opacity: 0;"></div>
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/Tproger_4.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
    </div>

    <div class="site-row">
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/Tproger_5.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
        <div class="work-desc wow slideInRight">
            <p>Админка проста, удобна и наглядна, содержит весь основной функционал. С целью демонстрации
                ее работы, вход на панель администратора свободный, но при этом права и привилегии корректно
                ограничивают каждого ее пользователя.</p>
        </div>
    </div>
@endsection