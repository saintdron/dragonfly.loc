<div class="container-fluid skills" data-title="{{ $title }}">
    @if ($skills)
        <ul>
            <li style="order: 0" class="transparent"></li>
            @php
                {{ $firstNumber = rand(0, count($skills) - 1);
                 $secondNumber = rand(6, count($skills) - 1); }}
            @endphp
            {{--@set($firstNumber,rand(0,5))
            @set($secondNumber,rand(6,count($skills)))--}}
            @foreach($skills as $k => $skill)
                @if($k === $firstNumber)
                    <li style="order: {{ $skill->order }};">
                        <div class="cut-in">
                            <p>Все показатели <b>приблизительны</b> и&nbsp;субъективны</p>
                        </div>
                    </li>
                @elseif($k === $secondNumber)
                    <li style="order: {{ $skill->order }};">
                        <div class="cut-in">
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

