<div class="container-fluid skills" data-title="{{ $title }}">
    @if ($skills)
        <ul>
            <li style="order: 0" class="transparent"></li>
            @foreach($skills as $skill)
                <li style="order: {{ $skill->order }};">
                    <div class="bar" data-progress="{{ $skill->level }}"></div>
                    <div class="tech">{{ $skill->tech }}</div>
                </li>
            @endforeach
        </ul>
    @endif
</div>

