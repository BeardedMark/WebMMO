<div class="frame flex-col-13">
    <div class="flex-row-8">
        <div class="flex-row flex grow">

            <div class="flex-col">
                <div class="flex-row-8">
                    <a class="link" href="{{ route('pages.main') }}">Главная</a>
                    <a class="link" href="{{ route('pages.about') }}">О игре</a>
                </div>

                <div class="flex-row-8">
                    <a class="link font-small" href="{{ route('locations.index') }}">Локации</a>
                    <a class="link font-small" href="{{ route('items.index') }}">Предметы</a>
                    <a class="link font-small" href="{{ route('enemies.index') }}">Враги</a>
                    {{-- <a class="link font-small" href="{{ route('characters.index') }}">Персонажи</a> --}}
                    {{-- <a class="link font-small" href="{{ route('users.index') }}">Пользователи</a> --}}
                    <a class="link font-small lock-gray-dark-blur" href="{{ route('users.index') }}">Объекты</a>
                    <a class="link font-small lock-gray-dark-blur" href="{{ route('users.index') }}">Области</a>
                    <a class="link font-small lock-gray-dark-blur" href="{{ route('users.index') }}">Активности</a>
                    <a class="link font-small lock-gray-dark-blur" href="{{ route('users.index') }}">Свойства</a>
                    <a class="link font-small lock-gray-dark-blur" href="{{ route('users.index') }}">События</a>
                    <a class="link font-small lock-gray-dark-blur" href="{{ route('users.index') }}">Нипы</a>
                </div>
            </div>
        </div>

        <div class="flex-row ai-center">
            @if (auth()->check())
                <div class="flex-col">
                    <p class="flex-row-8 jc-end text-end">
                        @if (isset(auth()->user()->character))
                            @component('db.transitions.components.timer', ['character' => auth()->user()->character])
                            @endcomponent

                            <a class="link text-end" href="{{ route('characters.show', auth()->user()->character) }}">
                                {{ auth()->user()->character->getTitle() }}
                            </a>
                        @else
                            <a class="link text-end font-small" href="{{ route('characters.select') }}">Выбрать
                                персонажа</a>
                        @endif

                        <span>
                            (<a class="link text-end"
                                href="{{ route('users.main') }}">{{ auth()->user()->login }}</a>)
                        </span>
                    </p>

                    <div class="flex-row-8 jc-end">
                        <a class="link font-small" href="{{ route('transitions.index') }}">Локация</a>
                        <a class="link font-small" href="{{ route('characters.inventory') }}">Инвентарь</a>

                        <a class="link font-small lock-gray-dark-blur"
                            href="{{ route('transitions.index') }}">Навыки</a>
                        <a class="link font-small lock-gray-dark-blur"
                            href="{{ route('transitions.index') }}">Задания</a>
                        <a class="link font-small lock-gray-dark-blur"
                            href="{{ route('transitions.index') }}">Контакты</a>
                    </div>
                </div>
            @else
                <div class="flex-col">
                    <p class="text-end">Добро пожаловать!</p>

                    <div class="flex-row-8 jc-end">
                        <a class="link text-end font-small" href="{{ route('users.login') }}">Вход</a>
                        <a class="link text-end font-small" href="{{ route('users.register') }}">Регистрация</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @component('partials.alerts')
    @endcomponent
</div>
