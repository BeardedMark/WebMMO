@extends('layouts.hug')

@section('content')
    <div class="flex-col-13">
        <div class="flex-col-13">
            <h1>Главная страница</h1>

            <div class="flex-row-8">
                <a class="button brand" href="{{ route('characters.create') }}">Начать игру</a>
            </div>
        </div>

        <div class="flex-col-13">
            <h2>Описание</h2>

            <p class="frame">Браузерная ММО с картой локаций, соединённых дорогами. Игроки перемещаются между ними с
                таймерами,
                собирают
                случайно сгенерированный лут, взаимодействуют с инвентарём, другими игроками и локациями. Всё строится
                на
                Laravel с SVG-картой и расширяемой системой предметов, событий и социальных взаимодействий</p>
        </div>

        <div class="flex-col-13">
            <h2>Механники</h2>

            <div class="row">
                <div class="col">
                    <div class="frame">
                        <p>Передвижение</p>

                        <ul>
                            <li>Атмосферные локации с активностями</li>
                            <li class="lock-opacity">Чат локации и список персонажей на ней</li>
                            <li>Открытие локаций путем их посещения</li>
                            <li>Переобход локаций для обновления активностей</li>
                            <li>Создание убежища для персонажей на локациях</li>
                            <li>Размер области влияет на время переобхода локации</li>
                            <li>Переходы между локациями по дорогам</li>
                            <li>Расстояние между локациями влияет на время в пути</li>
                        </ul>
                    </div>
                </div>

                <div class="col">
                    <div class="frame">
                        <p>Предметы</p>

                        <ul>
                            <li>Сбор предметов на локациях</li>
                            <li>Размер и уровень локации влияет на кол-во лута</li>
                            <li>Выпадение предметов зависит от уровня локаций</li>
                            <li class="lock-opacity">Привязка выпадения предметов к локациям</li>
                            <li>У всех предметов есть базовый шанс выпадения</li>
                            <li>Предметы имеют свой вес в инвентаре</li>
                            <li class="lock-opacity">Сбор и разбор предметов на составляющие</li>
                        </ul>
                    </div>
                </div>

                <div class="col lock-opacity">
                    <div class="frame">
                        <p>Планы</p>

                        <ul>
                            <li>Враги на локациях</li>
                            <li>Объекты на локациях</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <h2>Вдохновения</h2>
        <div class="frame flex-col-13">

            <div class="row">
                <div class="col">
                    <p>RUST</p>

                    <ul>
                        <li>Игровой мир и сюжет</li>
                        <li>Предметы и крафт</li>
                        <li>Система развития</li>
                    </ul>
                </div>

                <div class="col">
                    <p>Path of Exile</p>

                    <ul>
                        <li>Древовидность и гибкость</li>
                        <li>Свойства предметов и персонажей</li>
                        <li>Гринд и развитие экипировки</li>
                    </ul>
                </div>

                <div class="col">
                    <p>Carnage</p>

                    <ul>
                        <li>Механника перемещения</li>
                        <li>Боевая система</li>
                        <li>Система событий на локациях</li>
                    </ul>
                </div>

                <div class="col">
                    <p>В целом</p>

                    <ul>
                        <li>Убежища для персонажей</li>
                        <li>Система гильдий и груп</li>
                        <li>Социальные возможности</li>
                    </ul>
                </div>
            </div>
        </div>

        <h2>Ресурсы</h2>

        <div class="frame flex-col-13">
            <div class="row">
                <div class="col">
                    <p>Медиаконтент</p>

                    <ul>
                        <li><a class="link" href="https://zvukipro.com/" target="_blink">Озвучка</a></li>
                        <li><a class="link" href="https://icons8.ru/icons/set/home--style-windows"
                                target="_blink">Иконки</a></li>
                        <li><a class="link" href="https://chatgpt.com/" target="_blink">Изображения и текст</a></li>
                    </ul>
                </div>

                <div class="col">
                    <p>Инструменты</p>

                    <ul>
                        <li><a class="link" href="https://programforyou.ru/graph-redactor" target="_blink">Рaбота с
                                графами</a></li>
                        <li><a class="link" href="https://www.redblobgames.com/maps/mapgen4/" target="_blink">Генератор
                                мира</a></li>
                        <li><a class="link" href="https://randomall.ru/" target="_blink">Генератор лора</a></li>
                    </ul>
                </div>

                <div class="col">
                    <p>Технологии</p>

                    <ul>
                        <li><a class="link" href="https://hosting.timeweb.ru/" target="_blink">Хостинг и домен</a></li>
                        <li><a class="link" href="https://laravel.com/" target="_blink">Фреймворк</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
