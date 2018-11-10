<div class="container-fluid graphic-design" data-title="{{ $title }}">
    <section class="partitions">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('branding') }}">Корпоративный стиль</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('printing') }}">Полиграфическая продукция</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('graphicAnimations') }}">Видео и gif-анимация</a>
            </li>
        </ul>
    </section>
    @if($selected)
        <section class="main-work">
            <div class="work">
                <video width="100%" preload="auto" loop="loop" controls="controls"
                       poster="{{ asset(config('settings.graphicAnimations_dir')) . '/' . $selected->alias . '/' . $selected->img->poster }}">
                    <source src="{{ asset(config('settings.graphicAnimations_dir')) . '/' . $selected->alias . '/' . $selected->video->mp4 }}"
                            type='video/mp4;'>
                    <source src="{{ asset(config('settings.graphicAnimations_dir')) . '/' . $selected->alias . '/' . $selected->video->webm }}"
                            type='video/webm;'>
                </video>
            </div>
            <div class="description">
                <div class="desc_header">
                    <a href="{{ route('graphicAnimations', $selected->prev->alias) }}">
                        <span class="fas fa-arrow-circle-left arrow arrow-left"></span>
                    </a>
                    <a href="{{ route('graphicAnimations', $selected->next->alias) }}">
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
                            <a href="{{ route('graphicAnimations', $work->alias) }}">
                                <img src="{{ asset(config('settings.graphicAnimations_dir')) . '/' . $work->alias . '/' . $work->img->thumb }}">
                                <h4>{{ $work->title }}</h4>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </section>
    @endif
</div>