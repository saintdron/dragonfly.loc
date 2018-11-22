<section class="partitions">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link {{ $partition === 'sites' ? 'active' : '' }}" href="{{ route('sites') }}">Сайты</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $partition === 'services' ? 'active' : '' }}" href="{{ route('services') }}">Онлайн утилиты</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $partition === 'webAnimations' ? 'active' : '' }}" href="{{ route('webAnimations') }}">Веб-анимации</a>
        </li>
    </ul>
</section>