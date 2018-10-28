<div class="container-fluid graphic-design">
    <section class="partitions">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link {{ ($partition === 'branding') ? 'active' : ''}}"
                   href="{{ route('branding') }}">Брендирование</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ ($partition === 'printing') ? 'active' : ''}}"
                   href="{{ route('printing') }}">Полиграфическая продукция</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ ($partition === 'graphicAnimations') ? 'active' : ''}}"
                   href="{{ route('graphicAnimations') }}">Видео и gif-анимация</a>
            </li>
        </ul>
    </section>
    <section class="main-work">
        <a href="/assets/images/portfolio/graphic-design/branding/YG_Team.png" data-lightbox="image-1"
           data-title="Тестовое заглавие">
            <img src="/assets/images/portfolio/graphic-design/branding/YG_Team_big.png">
        </a>
        <div class="description">
            <div class="desc_header">
                <span class="fas fa-arrow-circle-left arrow arrow-left"></span>
                <span class="fas fa-arrow-circle-right arrow arrow-right"></span>
                <h2>Тестовое заглавие</h2>
            </div>
            <div class="desc_text">
                <p>При разработке сайта мы старались широко раскрыть все преимущества продукции и магазина, а так же
                    реализовать удобный функционал. На главной странице удачно размещен каталог товаров, который разбит
                    на 16 категорий, что сужает поиск и просмотр интересующего товара.</p>
            </div>
            <div class="desc_meta">
                <p><strong>Заказчик:</strong> ТОВ «Ковальська Майстерня»</p>
                <p><strong>Технологии:</strong> Adobe Photoshop, Illustrator</p>
                <p><strong>Дата:</strong> Июнь 2014</p>
            </div>
        </div>
    </section>
    <section class="another-works">
        <h3>Другие работы в этом разделе:</h3>
        <ul>
            <li>
                <img src="/assets/images/portfolio/graphic-design/branding/YG_Team_small.png">
                <h4>Тестовое заглавие</h4>
            </li>
            <li>
                <img src="/assets/images/portfolio/graphic-design/branding/YG_Team_small.png">
                <h4>Donsifon fedrtfew dfewrwr</h4>
            </li>
            <li>
                <img src="/assets/images/portfolio/graphic-design/branding/YG_Team_small.png">
                <h4>Тестовое</h4>
            </li>
            <li><img src="/assets/images/portfolio/graphic-design/branding/YG_Team_small.png"></li>
            <li><img src="/assets/images/portfolio/graphic-design/branding/YG_Team_small.png"></li>
            <li><img src="/assets/images/portfolio/graphic-design/branding/YG_Team_small.png"></li>
            <li><img src="/assets/images/portfolio/graphic-design/branding/YG_Team_small.png"></li>
            <li><img src="/assets/images/portfolio/graphic-design/branding/YG_Team_small.png"></li>
        </ul>
    </section>
</div>