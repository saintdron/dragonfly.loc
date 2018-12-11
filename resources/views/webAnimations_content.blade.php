<div class="container-fluid graphic-design web-animations" data-title="{{ $title }}">
    @if(isset($partitions_view) && $partitions_view)
        {!! $partitions_view !!}
    @endif
    @if(isset($selected) && $selected)
        <section class="main-work">
            <div class="work">
                @if($selected->script)
                    <div class="dynamic {{ $selected->alias }}"
                         data-script="{{ asset(config('settings.webAnimations_dir')). '/' . $selected->alias . '/' . $selected->alias . '.js' }}"
                         data-style="{{ asset(config('settings.webAnimations_dir')). '/' . $selected->alias . '/' . $selected->alias . '.css' }}">
                        <img src="{{ asset('assets') . '/images/dummy_big.png' }}">
                    </div>
                    @if($selected->alias === 'connected-dots')
                        <div class="tuning">
                            <div class="tuning__dots" style="width: 20%">
                                <label for="dots">Точки</label>
                                <input type="range" min="1" max="400" step="1" value="180" name="dots" id="dots">
                                <output>180</output>
                            </div>
                            <div class="tuning__connections" style="width: 20%">
                                <label for="connections">Линии</label>
                                <input type="range" min="0" max="25" step="1" value="10" name="connections"
                                       id="connections">
                                <output>10</output>
                            </div>
                            <div class="tuning__range" style="width: 20%">
                                <label for="connections">Радиус</label>
                                <input type="range" min="100" max="22500" step="1" value="6400" name="range" id="range">
                                <output>80</output>
                            </div>
                            <div class="tuning__nodes" style="width: 20%">
                                <label for="nodes">Узлы</label>
                                <input type="checkbox" class="checkbox-switch" name="nodes" id="nodes">
                            </div>
                        </div>
                    @endif
                @else
                    @if($selected->img->original)
                        <a href="{{ asset(config('settings.webAnimations_dir')) . '/' . $selected->alias . '/' . $selected->img->original }}"
                           data-lightbox="image-1"
                           data-title="{{ $selected->title }}">
                            @endif
                            <img src="{{ $selected->img->big
                    ? asset(config('settings.webAnimations_dir')) . '/' . $selected->alias . '/' . $selected->img->big
                    : asset('assets') . '/images/dummy_big.png'}}">
                            @if($selected->img->original)
                        </a>
                    @endif
                @endif
            </div>
            <div class="description">
                <div class="desc_header">
                    @if($works && count($works) > 1)
                        <a href="{{ route('webAnimations', $selected->prev->alias) }}"
                           title="Перейти к предыдущей работе">
                            <span class="fas fa-arrow-circle-left arrow arrow-left"></span>
                        </a>
                        <a href="{{ route('webAnimations', $selected->next->alias) }}"
                           title="Перейти к следующей работе">
                            <span class="fas fa-arrow-circle-right arrow arrow-right"></span>
                        </a>
                    @endif
                    <h2>{{ $selected->title }}
                        <a href="{{ asset(config('settings.webAnimations_dir')). '/' . $selected->alias . '/' . $selected->alias . '.js' }}"
                           title="Открыть код анимации">
                            <span class="fas fa-external-link-alt external-link"></span>
                        </a>
                    </h2>
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
                            <a href="{{ route('webAnimations', $work->alias) }}">
                                <img src="{{ asset(config('settings.webAnimations_dir')) . '/' . $work->alias . '/' . $work->img->small }}">
                                <h4>{{ $work->title }}</h4>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </section>
    @endif
</div>