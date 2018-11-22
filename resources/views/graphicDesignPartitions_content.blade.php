<section class="partitions">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link {{ $partition === 'branding' ? 'active' : '' }}" href="{{ route('branding') }}">Корпоративный стиль</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $partition === 'printing' ? 'active' : '' }}" href="{{ route('printing') }}">Полиграфическая продукция</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $partition === 'graphicAnimations' ? 'active' : '' }}" href="{{ route('graphicAnimations') }}">Видео и gif-анимация</a>
        </li>
    </ul>
</section>