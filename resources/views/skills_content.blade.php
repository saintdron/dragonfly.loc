<div class="container-fluid skills" data-title="{{ $title }}">
    @if ($skills)
        <ul>
            <li style="order: 0" class="transparent"></li>
            @php
                {{ $firstNumber = rand(1, 6);
                 $secondNumber = rand(7, count($skills) - 1); }}
            @endphp
            @foreach($skills as $k => $skill)
                @if($k === $firstNumber)
                    <li class="cut-in" style="order: {{ $skill->order }};">
                        <div>
                            <p>Все показатели <b>приблизительны</b> и&nbsp;субъективны</p>
                        </div>
                    </li>
                @elseif($k === $secondNumber)
                    <li class="cut-in" style="order: {{ $skill->order }};">
                        <div>
                            <blockquote>
                                <p>Всякая <b>точная</b> наука основывается на приблизительности.</p>
                                <cite>Бертран Рассел</cite>
                            </blockquote>
                        </div>
                    </li>
                @endif
                <li style="order: {{ $skill->order }};">
                    <div class="bar" data-progress="{{ $skill->level }}"></div>
                    <div class="tech">{{ $skill->tech }}</div>
                </li>
            @endforeach
        </ul>
    @endif
</div>

