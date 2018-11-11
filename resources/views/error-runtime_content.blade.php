<div class="container-fluid error error-runtime" data-title="{{ $title ?? '' }}">
    @if(isset($partitions) && $partitions)
        {!! $partitions !!}
    @endif
    <div class="content">
        <figure>
            <img src="{{ asset(config('settings.gif_dir')) . '/error-runtime.gif' }}" alt="Стрекоза у пруда">
            <figcaption>Затянулась бурой тиной<br>
                Гладь старинного пруда...
            </figcaption>
        </figure>
        <p>{{ (isset($message) && $message) ? $message : 'При загрузке страницы произошла ошибка.' }}</p>
        {{--<a href="{{ route('index') }}" role="button">Вернуться на главную</a>--}}
    </div>
</div>