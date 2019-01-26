<div class="container-fluid sites" data-title="{{ $title }}">
    @if(isset($partitions_view) && $partitions_view)
        {!! $partitions_view !!}
    @endif
    @if($works)
        <section class="works">
            <img id="wing" src="{{ asset('assets') }}/images/wing.png" style="display: none;">
            @foreach($works as $work)
                <a class="site-button {{ $work->alias }}" href="{{ route('sites', $work->alias) }}"
                   style="background: url({{ asset(config('settings.sites_dir')) . '/' . $work->alias . '/cover.png' }})">
                    <div class="curtain"></div>
                    <img class="logo"
                         src="{{ asset(config('settings.sites_dir')) . '/' . $work->alias . '/logo.png' }}">
                    <h3>{{ $work->title }}</h3>
                </a>
            @endforeach
        </section>
    @endif
</div>