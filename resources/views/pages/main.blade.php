@extends('layouts.hug')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="img-contain" style="height: 500px">
            <img src="{{ asset('storage/images/logo.png') }}" alt="">
        </div>
    </div>

    <div class="row align-items-center">
        <div class="col-12 col-md">
            <div class="flex-col-13 pad-13">
                <h1 class="color-brand">Remnants of the Future</h1>

                <div class="flex-col">
                    <p class="font-lg color-accent">Жизнь на остатках будущего</p>
                    <p>Исследуй, выживай, строй и меняй судьбу мира в игре, где каждая деталь важна</p>
                </div>

                <span class="font-sm color-second">Узнать
                    <a class="link" href="{{ route('pages.about') }}">Подробнее</a>
                    о геймплее</span>
            </div>
        </div>

        <div class="col-12 col-md-5">
            <p class="flex-col-8 pad-13 ai-end">
                <a class="button brand font-lg" href="{{ route('transitions.index') }}">Начать игру</a>
            </p>
        </div>
    </div>

    <div class="frame img-cover" style="height: 250px">
        <img src="{{ asset('storage/images/pages/main/preview.png') }}" alt="">
        {{-- <p class="absolute font-xxl font-light-brand">Большой мир</p> --}}
    </div>

    <div class="flex-col-13">
        <div class="pad-13">
            <div class="row g-4">
                <div class="col-12 col-md">
                    <div class="flex-col-8">
                        <h3>Путешествуй по живой карте</h3>
                        <p class="p-indent">Мир игры состоит из уникальных локаций, связанных между собой дорогами. Каждый
                            переход — это реальное путешествие, с ожиданием, рисками и шансом на неожиданное событие.
                            Нападения, находки, встречи — всё это может случиться в пути
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md">
                    <div class="flex-col-8">
                        <h3>Мир создаётся вместе с тобой</h3>
                        <p class="p-indent">Каждое существо, предмет или объект в игре — уникален. Генерация контента
                            основана на шаблонах и случайности. Один и тот же лут может быть ценным, бесполезным или
                            смертельно опасным — в зависимости от параметров и модификаторов
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md">
                    <div class="flex-col-8">
                        <h3>Каждый предмет — уникален</h3>
                        <p class="p-indent">Инвентарь — это не просто список. Все предметы существуют как отдельные
                            экземпляры: их можно разобрать, улучшить, скомбинировать. Экипировка влияет на параметры
                            персонажа и определяет твой стиль игры
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="frame img-cover" style="height: 500px">
        <img src="{{ asset('storage/images/pages/main/history.png') }}" alt="">
        {{-- <p class="absolute font-xxl font-light-brand">Интересные локации</p> --}}
    </div>

    <div class="flex-col-8 pad-13">
        <h2>Природа победила стекло и бетон</h2>
        <p>Мир молчит. Остались только ты и то, что ты сделаешь</p>
        <p class="font-sm color-second">Узнать
            <a class="link" href="{{ route('pages.lore') }}">Подробнее</a>
            о истории мира</p>
    </div>

    <div class="flex-col-13 pad-13">
        <div class="row g-4">
            <div class="col-12 col-md">
                <div class="flex-col-8">
                    <h3>Как было</h3>
                    <p class="p-indent">Мир когда-то жил в изобилии и покое. Искусственный интеллект управлял всем — от
                        транспорта до здравоохранения. Люди не строили, не готовили, не лечили — всё делали машины. Это
                        была эпоха цифрового комфорта
                    </p>
                </div>
            </div>

            <div class="col-12 col-md">
                <div class="flex-col-8">
                    <h3>Что случилось</h3>
                    <p class="p-indent">Но системы начали давать сбои. Без знаний и навыков люди не смогли их
                        восстановить. Цивилизация замерла — не разрушенная, а забытая. Теперь, спустя двадцать лет,
                        человечество живёт среди ржавчины и мха, учась выживать заново
                    </p>
                </div>
            </div>

            <div class="col-12 col-md">
                <div class="flex-col-8">
                    <h3>Как стало</h3>
                    <p class="p-indent">Природа вернула себе города. Техника стала артефактами. Социальные связи
                        ослабли. Настоящее — это мир, собранный вручную
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="frame img-cover" style="height: 250px">
        <img src="{{ asset('storage/images/pages/main/world.png') }}" alt="">
        {{-- <p class="absolute font-xxl font-light-brand">Уникальный лут</p> --}}
    </div>

    <div class="flex-col-13">
        <div class="pad-13">
            <div class="row g-4">
                <div class="col-12 col-md">
                    <div class="flex-col-8">
                        <h3>Ты не один в этом мире</h3>
                        <p class="p-indent">Объединяйся в группы, создавай гильдии, сражайся с врагами или с другими
                            игроками. Торгуй, договаривайся, вступай в конфликты или мирись. В игре есть внутриигровой чат,
                            личные сообщения и открытый рынок
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md">
                    <div class="flex-col-8">
                        <h3>Создавай, исследуй, вливайся</h3>
                        <p class="p-indent">Строй собственное убежище. Расширяй его, защищай, улучшай. В локациях происходят
                            события: атаки, аномалии, редкие находки. Игровой мир живёт, даже когда ты не играешь
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md">
                    <div class="flex-col-8">
                        <h3>Какое будущее выберешь ты?</h3>
                        <p class="p-indent">Ты можешь вернуть технологии или жить в гармонии с природой. Можешь собирать
                            сообщества или идти в одиночку. Мир открыт, но не навязан. Здесь нет правильного пути — только
                            твой
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-col-13">
        <div class="row g-4 align-items-center">
            <div class="col-6 col-md-3">
                <div class="frame img-contain">
                    <a href="{{ asset('storage/images/screenshots/location.png') }}" target="_blink">
                        <img src="{{ asset('storage/images/screenshots/location.png') }}" alt="">
                    </a>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="frame img-contain">
                    <a href="{{ asset('storage/images/screenshots/transition.png') }}" target="_blink">
                        <img src="{{ asset('storage/images/screenshots/transition.png') }}" alt="">
                    </a>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="frame img-contain">
                    <a href="{{ asset('storage/images/screenshots/inventory.png') }}" target="_blink">
                        <img src="{{ asset('storage/images/screenshots/inventory.png') }}" alt="">
                    </a>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="frame img-contain">
                    <a href="{{ asset('storage/images/screenshots/battle.png') }}" target="_blink">
                        <img src="{{ asset('storage/images/screenshots/battle.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row ai-center">
        <div class="col-6 col-md-3 order-2 order-md-1">
            <div class="img-cover">
                <img src="{{ asset('storage/images/npc/xenon.png') }}" alt="">
            </div>
        </div>

        <div class="col-12 col-md order-1 order-md-2">
            <div class="flex-col-13 pad-13 text-center">
                <h1 class="color-brand">Ты готов начать свою историю?</h1>

                <div class="flex-col">
                    <p class="font-lg color-accent">Играй прямо в браузере — без установки и бесплатно</p>
                    <p>Исследуй, строй, выживай и оставь след в новом мире</p>
                </div>

                <p class="flex-col-8 ai-center">
                    <a class="button brand font-lg" href="{{ route('transitions.index') }}">Начать игру</a>
                </p>
            </div>
        </div>

        <div class="col-6 col-md-3 order-3 order-md-3">
            <div class="img-cover">
                <img src="{{ asset('storage/images/npc/astat.png') }}" alt="">
            </div>
        </div>
    </div>
@endsection
