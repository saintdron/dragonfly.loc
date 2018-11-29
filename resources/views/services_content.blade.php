<div class="container-fluid services" data-title="{{ $title }}">
    @if(isset($partitions_view) && $partitions_view)
        {!! $partitions_view !!}
    @endif
    @if($works)
        <section class="works">
            <ul>
                @foreach($works as $work)
                    <li>
                        <a href="{{ route('services', $work->alias) }}">
                            <img src="{{ asset(config('settings.services_dir')) . '/' . $work->alias . '/' . $work->img->sign }}">
                            <p>{{ $work->title }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif
</div>