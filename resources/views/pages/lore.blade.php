@extends('layouts.hug')

@section('content')
    <div class="flex-col-8 pad-13">
        <h1 class="color-brand">Мир игры — основа лора</h1>
        <p class="font-lg">Мир, где прошлое забыто, настоящее собрано заново, а будущее зависит от тебя</p>
    </div>


    <div class="flex-col-13">
        <div class="row align-items-center">
            <div class="col-12 col-md">
                <div class="flex-col-8 pad-13">
                    <h2>Прошлое</h2>
                    <p class="p-indent">Мир когда-то жил в изобилии и покое. Искусственный интеллект управлял всем — от
                        транспорта до здравоохранения. Люди не строили, не готовили, не лечили — всё делали машины. Это была
                        эпоха цифрового комфорта, где технологии брали на себя каждый шаг. Глобальная экосистема сервисов
                        обеспечивала бесперебойную работу цивилизации. Мир стал быстрым, безопасным… и полностью зависимым
                        от алгоритмов.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-5">
                <div class="frame img-contain">
                    <img src="{{ asset('storage/images/pages/lore/past.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>

    <div class="flex-col-13">
        <div class="row align-items-center">
            <div class="col-12 col-md-5">
                <div class="frame img-contain">
                    <img src="{{ asset('storage/images/pages/lore/backstory.png') }}" alt="">
                </div>
            </div>

            <div class="col-12 col-md">
                <div class="flex-col-8 pad-13">
                    <h2>Предыстория</h2>
                    <p class="p-indent">Переход в эпоху тишины был незаметным. Ни катастроф, ни войн. Просто однажды системы
                        начали давать сбои. Некому было их перезапустить. Люди утратили базовые навыки. Цифровое поколение
                        оказалось неспособным чинить, добывать, выращивать. Когда молчание охватило сети, наступила
                        стагнация. Годы прошли, и цивилизация остановилась — не разрушенная, а забытая. Мир погрузился в
                        техногенное забвение.

                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-col-13">
        <div class="row align-items-center">
            <div class="col-12 col-md">
                <div class="flex-col-8 pad-13">
                    <h2>Настоящее</h2>
                    <p class="p-indent">Прошло около двадцати лет. Электричество — редкая находка. Рабочая техника — ещё
                        большая редкость. Города заросли, поля поглотили дороги, терминалы ржавеют под дождём. Люди живут в
                        небольших общинах и одиночных убежищах. Они учатся заново: добывать ресурсы, чинить найденное,
                        строить из остатков. Социальные связи слабые, но живые — торговля, кооперация, конфликты. Мир не
                        разрушен — он вручную собран заново.
                    </p>
                </div>
            </div>

            <div class="col-12 col-md-5">
                <div class="frame img-contain">
                    <img src="{{ asset('storage/images/pages/lore/present.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>


    <div class="flex-col-13">
        <div class="row align-items-center">
            <div class="col-12 col-md-5">
                <div class="frame img-contain">
                    <img src="{{ asset('storage/images/pages/lore/future.png') }}" alt="">
                </div>
            </div>

            <div class="col-12 col-md">
                <div class="flex-col-8 pad-13">
                    <h2>Будущее</h2>
                    <p class="p-indent">Мир ждет тех, кто решится выбрать путь. Вернёшь ли ты технологии и возродишь
                        утраченное? Откажешься от прошлого и станешь жить заново, без машин? Или найдёшь свою середину —
                        между искрой и деревом, между разумом и интуицией? Создавай общины или выживай в одиночку. Влияй на
                        судьбы других или прячься в тени. Здесь нет правильного пути — только твой. Выбор за тобой.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
