<div class="container-fluid graphic-design">
    <section class="partitions">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('branding') }}">Брендирование</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('printing') }}">Полиграфическая продукция</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('graphicAnimations') }}">Видео и gif-анимация</a>
            </li>
        </ul>
    </section>
    @if($selected)
        <section class="main-work">
            <a href="{{ asset(config('settings.printing_dir')) . '/' . $selected->img->original }}"
               data-lightbox="image-1"
               data-title="{{ $selected->title }}">
                <img src="{{ asset(config('settings.printing_dir')) . '/' . $selected->img->big }}">
            </a>
            <div class="description">
                <div class="desc_header">
                    <a href="{{ route('printing', $selected->prev->alias) }}">
                        <span class="fas fa-arrow-circle-left arrow arrow-left"></span>
                    </a>
                    <a href="{{ route('printing', $selected->next->alias) }}">
                        <span class="fas fa-arrow-circle-right arrow arrow-right"></span>
                    </a>
                    <h2>{{ $selected->title }}</h2>
                </div>
                <div class="desc_text">
                    <p>{{ $selected->text }}</p>
                </div>
                <div class="desc_meta">
                    <p><strong>Заказчик:</strong> {{ $selected->customer }}</p>
                    <p><strong>Технологии:</strong> {{ $selected->techs }}</p>
                    <p><strong>Дата:</strong> {{ $selected->created_at }}</p>
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
                            <a href="{{ route('printing', $work->alias) }}">
                                <img src="{{ asset(config('settings.printing_dir')) . '/' . $work->img->small }}">
                                <h4>{{ $work->title }}</h4>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </section>
    @endif
</div>