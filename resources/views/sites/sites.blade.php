<div class="container-fluid sites" data-title="{{ $title }}">
    @if(isset($partitions_view) && $partitions_view)
        {!! $partitions_view !!}
    @endif
    @if($work)
        <div class="main-content {{ $work->alias }}">
            <div class="site-nav">
                <h2>
                    @if($work->prev || $work->next)
                        <a href="{{ route('sites', $work->prev) }}" title="Перейти к предыдущей работе">
                            <span class="fas fa-arrow-circle-left arrow arrow-left"></span>
                        </a>
                        <a href="{{ route('sites', $work->next) }}" title="Перейти к следующей работе">
                            <span class="fas fa-arrow-circle-right arrow arrow-right"></span>
                        </a>
                    @endif
                    {{ $work->title }}
                    @if($work->live_version)
                        <a href="{{ $work->live_version }}"
                           title="Открыть живую версию сайта">
                            <span class="fas fa-external-link-alt external-link"></span>
                        </a>
                    @endif
                </h2>
                <div class="back">
                    <a href="{{ route('sites') }}">
                        <div class="btn btn-d"><i class="fas fa-backspace"></i><span> Вернуться</span></div>
                    </a>
                </div>
            </div>
            <div class="site-content">
                <!-- Site-Content -->
                @yield('site-content')
            </div>
            <div class="desc_meta">
                @if($work->customer)
                    <p><strong>Заказчик:</strong> {{ $work->customer }}</p>
                @endif
                @if($work->techs)
                    <p><strong>Технологии:</strong> {{ $work->techs }}</p>
                @endif
                @if($work->created_at)
                    <p><strong>Дата:</strong> {{ $work->created_at }}</p>
                @endif
                @if($work->live_version)
                    <a class="btn-d btn-site" href="{{ $work->live_version }}"><i class="fas fa-external-link-alt"></i>
                        Перейти на сайт</a>
                @endif
            </div>
            <div class="site-footer"></div>
        </div>
    @endif
</div>