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
            <div class="work-block" style="margin-bottom: 30px;">
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

    <div class="site-row special-2">
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <div class="error error-runtime preview">
                    @if(isset($partitions_view) && $partitions_view)
                        {!! $partitions_view !!}
                    @endif
                    <div class="content">
                        <figure>
                            <img src="{{ asset(config('settings.gif_dir')) . '/error-runtime.gif' }}"
                                 alt="Стрекоза у пруда">
                            <figcaption>Затянулась бурой тиной<br>
                                Гладь старинного пруда...
                            </figcaption>
                        </figure>
                        <p>При загрузке страницы произошла ошибка.</p>
                    </div>
                </div>
            </div>
            <div class="work-footer"></div>
        </div>
        <div class="work-block">
            <div class="work-header"></div>
            <div class="work">
                <div class="error error-404 preview">
                    <div class="content">
                        <div class="code">
                            <div class="code__number">4</div>
                            <div class="code__image">
                                <img src="{{ asset(config('settings.gif_dir')) . '/404.gif' }}">
                            </div>
                            <div class="code__number">4</div>
                        </div>
                        <p>Добыть указанную страницу не удастся&nbsp;– она отсутствует на&nbsp;сайте.</p>
                        <a href="javascript:void(0)" role="button">Вернуться на главную</a>
                    </div>
                </div>
            </div>
            <div class="work-footer"></div>
        </div>
    </div>
@endsection