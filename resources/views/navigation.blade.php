<div class="navigation {{ ($navPosition) ? 'inCorner navigation_' . $navPosition : 'navigation_center' }}">
    <div class="lily_back">
        <img src="{{ asset('assets') }}/images/water_lily_back.png">
    </div>
    <div class="menu menu_left-top"><a
{{--                href="{{ ($navPosition === 'right-bottom') ? route('index') : ($menu[0] ?? '#')}}"--}}
                href="{{ $menu[0] ?? '#' }}"
                draggable='false'></a></div>
    <div class="menu menu_right-top"><a href="{{ $menu[1] ?? '#'}}" draggable='false'></a></div>
    <div class="menu menu_left-bottom"><a href="{{ $menu[2] ?? '#'}}" draggable='false'></a></div>
    <div class="menu menu_right-bottom"><a href="{{ $menu[3] ?? '#'}}" draggable='false'></a></div>
    <div class="menu-content">
        <div class="menu-content_left-top {{ ($navPosition === 'right-bottom') ? 'menu-content_house' : '' }}">
            <h2 class="animated fadeInDown faster" style="display: none;">Веб-дизайн и&nbsp;разработка</h2>
            <p style="display: none;">
                <span class="animated fadeInLeftBig faster">Готовые сайты,</span><br>
                <span class="animated fadeInLeftBig faster">онлайн утилиты,</span><br/>
                <span class="animated fadeInLeftBig faster">JS- и CSS-анимации</span>
            </p>
        </div>
        <div class="menu-content_right-top {{ ($navPosition === 'left-bottom') ? 'menu-content_house' : '' }}">
            <h2 class="animated fadeInDown faster" style="display: none;">Графический дизайн</h2>
            <p style="display: none;">
                <span class="animated fadeInRightBig faster">Брендирование,</span><br>
                <span class="animated fadeInRightBig faster">полиграфическая продукция,</span><br/>
                <span class="animated fadeInRightBig faster">видео и gif-анимации</span>
            </p>
        </div>
        <div class="menu-content_left-bottom {{ ($navPosition === 'right-top') ? 'menu-content_house' : '' }}">
            <h2 class="animated fadeInUp faster" style="display: none;">Навыки</h2>
            <p style="display: none;">
                <span class="animated fadeInLeftBig faster">Квалификация в&nbsp;области программирования</span>
            </p>
        </div>
        <div class="menu-content_right-bottom {{ ($navPosition === 'left-top') ? 'menu-content_house' : '' }}">
            <h2 class="animated fadeInUp faster" style="display: none;">Обо мне</h2>
            <p style="display: none;">
                <span class="animated fadeInRightBig faster">Контактная информация,</span><br>
                <span class="animated fadeInRightBig faster">резюме</span>
            </p>
        </div>
    </div>
    <div class="lily_front">
        <img src="{{ asset('assets') }}/images/water_lily_front.png">
    </div>
</div>