<div class="flex-col-13">
    <div class="flex-row-8">
        <div class="flex-row flex grow">
            <div class="flex-col">
                <div class="flex-row-8">
                    <p>Remnants of the Future</p>
                    {{-- <a class="link" href="{{ route('pages.main') }}">Remnants of the Future</a> --}}
                </div>

                <div class="flex-row-8">
                    <a class="link font-sm" href="{{ route('pages.main') }}">Главная</a>
                    <a class="link font-sm" href="{{ route('pages.lore') }}">Лор</a>
                    <a class="link font-sm" href="{{ route('pages.about') }}">Геймплей</a>
                    <a class="link font-sm" href="{{ route('users.index') }}">Пользователи</a>
                    <a class="link font-sm" href="{{ route('characters.index') }}">Персонажи</a>
                </div>
            </div>
        </div>

        <div class="flex-row ai-center">
            @if (auth()->check())
                <div class="flex-col">
                    <p class="flex-row-8 jc-end ai-center text-end">
                        @if (!empty(auth()->user()->currentCharacter()))
                            @component('db.transitions.components.timer', ['character' => auth()->user()->currentCharacter()])
                            @endcomponent

                            <span
                                class="color-second font-sm">{{ auth()->user()->currentCharacter()->getOnlineTitle() }}</span>

                            <a class="link text-end"
                                href="{{ route('characters.show', auth()->user()->currentCharacter()) }}">
                                {{ auth()->user()->currentCharacter()->getTitle() }}
                            </a>
                        @else
                            @if (count(auth()->user()->characters) > 0)
                                <span class="color-second">Нет активного персонажа</span>
                            @else
                                <span class="color-second">У вас пока нет персонажей</span>
                            @endif
                        @endif

                        <span>
                            (<a class="link text-end" href="{{ route('users.main') }}">{{ auth()->user()->login }}</a>)
                        </span>
                    </p>

                    <div class="flex-row-8 jc-end">
                        @if (auth()->user()->currentCharacter())
                            <a class="link font-sm" href="{{ route('transitions.index') }}">Локация</a>
                            <a class="link font-sm" href="{{ route('characters.inventory') }}">Инвентарь</a>

                            <a class="link font-sm lock-gray-dark-blur">Навыки</a>
                            <a class="link font-sm lock-gray-dark-blur">Задания</a>
                            <a class="link font-sm lock-gray-dark-blur">Контакты</a>
                        @else
                            @if (count(auth()->user()->characters) > 0)
                                <a class="link text-end font-sm" href="{{ route('characters.select') }}">Выбрать
                                    персонажа</a>
                            @else
                                <a class="link text-end font-sm" href="{{ route('characters.create') }}">Создать
                                    персонажа</a>
                            @endif
                        @endif
                    </div>
                </div>
            @else
                <div class="flex-col">
                    <p class="text-end">Добро пожаловать!</p>

                    <div class="flex-row-8 jc-end">
                        <a class="link text-end font-sm" href="{{ route('users.login') }}">Вход</a>
                        <span class="color-second font-sm">или</span>
                        <a class="link text-end font-sm" href="{{ route('users.register') }}">Регистрация</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @component('partials.alerts')
    @endcomponent
</div>
