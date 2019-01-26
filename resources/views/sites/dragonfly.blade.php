@extends('sites.sites')

@section('site-content')
    <div class="site-row">
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/DragonFly_1.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
        <div class="work-desc">
            <p>Собственно сам сайт, который вы так любезно решили посетить. Авторское меню и динамичный фон встречают
                вас уже на главной странице. Перемещение по сайту осуществляется благодаря технологии Ajax.</p>
        </div>
    </div>

    <div class="site-row reverse">
        <div class="work-desc wow slideInLeft">
            <p>На сайте присутствуют некоторые из моих работ в качестве дизайнера, вертальщика и программиста.</p>
        </div>
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/DragonFly_6.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
    </div>

    <div class="site-row special-1">
        <div>
            <div class="work-block">
                <div class="work-header"></div>
                <div class="work">
                    <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/DragonFly_2.jpg">
                </div>
                <div class="work-footer"></div>
            </div>
            <div class="work-block">
                <div class="work-header"></div>
                <div class="work">
                    <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/DragonFly_5.jpg">
                </div>
                <div class="work-footer"></div>
            </div>
        </div>
        <div>
            <div class="work-block">
                <div class="work-header"></div>
                <div class="work">
                    <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/DragonFly_7.jpg">
                </div>
                <div class="work-footer"></div>
            </div>
            <div class="work-desc wow slideInRight">
                <p>Каждая страница сайта динамична и адаптивна (легко подстраивается под размер вашего экрана).</p>
            </div>
        </div>
    </div>

    <div class="site-row reverse">
        <div class="work-desc wow slideInLeft">
            <p>Также здесь присутствуют сервисы, которые могут оказаться для вас весьма полезными, хотя первостепенная
                их задача, конечно же, продемонстрировать мои навыки в сфере программирования.</p>
        </div>
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/DragonFly_4.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
    </div>

    <div class="site-row">
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <img src="{{ asset(config("settings.sites_dir")) }}/{{ $work->alias }}/DragonFly_3.jpg">
            </div>
            <div class="work-footer"></div>
        </div>
        <div class="work-desc wow slideInRight">
            <p>И, конечно же, среди прочих сервисов выделяется «Реформатор текста»: около 2000 строк кода, почти 200
                регулярных выражений смогут помочь любому, особенно, если речь идет о верстке полиграфической
                продукции.</p>
        </div>
    </div>
@endsection