<div class="container-fluid services" data-title="{{ $title }}">
    @if(isset($partitions_view) && $partitions_view)
        {!! $partitions_view !!}
    @endif
    @if($works)
        <section class="works">
            @foreach($works as $work)
                <a class="service-button" href="{{ route('services', $work->alias) }}">
                    <img class="{{ $work->alias }}"
                         src="{{ asset(config('settings.services_dir')) . '/' . $work->alias . '/' . $work->img->sign }}">
                    <p>{{ $work->title }}</p>
                </a>
            @endforeach
        </section>
    @endif
</div>