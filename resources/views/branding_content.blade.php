<div class="container-fluid graphic-design" data-title="{{ $title }}">
    @if(isset($partitions) && $partitions)
        {!! $partitions !!}
    @endif
    @if(isset($selected) && $selected)
        <section class="main-work">
            <a href="{{ asset(config('settings.branding_dir')) . '/' . $selected->alias . '/' . $selected->img->original }}"
               data-lightbox="image-1"
               data-title="{{ $selected->title }}">
                <img src="{{ asset(config('settings.branding_dir')) . '/' . $selected->alias . '/' . $selected->img->big }}">
            </a>
            <div class="description">
                <div class="desc_header">
                    <a href="{{ route('branding', $selected->prev->alias) }}">
                        <span class="fas fa-arrow-circle-left arrow arrow-left"></span>
                    </a>
                    <a href="{{ route('branding', $selected->next->alias) }}">
                        <span class="fas fa-arrow-circle-right arrow arrow-right"></span>
                    </a>
                    <h2>{{ $selected->title }}</h2>
                </div>
                <div class="desc_text">
                    <p>{!! $selected->text !!}</p>
                </div>
                <div class="desc_meta">
                    @if($selected->customer)
                        <p><strong>Заказчик:</strong> {{ $selected->customer }}</p>
                    @endif
                    @if($selected->techs)
                        <p><strong>Технологии:</strong> {{ $selected->techs }}</p>
                    @endif
                    @if($selected->created_at)
                        <p><strong>Дата:</strong> {{ $selected->created_at }}</p>
                    @endif
                </div>
            </div>
        </section>
    @endif
    @if($works && count($works) > 1)
        <section class="another-works">
            <h3>Другие работы в этом разделе:</h3>
            <ul>
                @foreach($works as $work)
                    @if($work->alias !== $selected->alias)
                        <li>
                            <a href="{{ route('branding', $work->alias) }}">
                                <img src="{{ asset(config('settings.branding_dir')) . '/' . $work->alias . '/' . $work->img->small }}">
                                <h4>{{ $work->title }}</h4>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </section>
    @endif
</div>