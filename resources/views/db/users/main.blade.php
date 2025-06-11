@extends('layouts.container')

@section('content')
    <div class="row">
        <div class="col">
            <div class="flex-col-55">
                <div class="flex-col-8 pad-13">
                    <h1 class="color-brand">Личный кабинет</h1>
                    <p class="font-lg">Страница управления профилем</p>
                </div>

                <div class="flex-col-13">
                    <div class="flex-col-8 pad-13">
                        <h2>Персонажи</h2>
                        <p>Управление вашими персонажами</p>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="frame flex-col-8">
                                @component('components.stat', ['name' => 'Максимум персонажей', 'value' => '5'])
                                @endcomponent

                                <a class="button" href="{{ route('characters.create') }}">Новый персонаж</a>
                            </div>
                        </div>

                        <div class="col">
                            <div class="frame flex-col-8">
                                @component('components.stat', ['name' => 'Создано персонажей', 'value' => count(auth()->user()->characters)])
                                @endcomponent

                                <a class="button {{ count(auth()->user()->characters) <= 0 ? 'lock-gray-dark-blur' : ''}}" href="{{ route('characters.select') }}">Сменить персонажа</a>
                            </div>
                        </div>

                        <div class="col h-100">
                            <div class="frame flex-col-8">
                                @if (auth()->user()->currentCharacter())
                                    @component('db.characters.components.line', ['character' => auth()->user()->currentCharacter()])
                                    @endcomponent

                                    <a class="button"
                                        href="{{ route('characters.edit', auth()->user()->currentCharacter()) }}">Редактировать
                                        текущего</a>
                                @else
                                    <p class="color-second">Нет активного персонажа</p>

                                    <a class="button lock-gray-dark-blur" href="">Редактировать
                                        текущего</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-col-13" data-tooltip="Скоро...">
                    <div class="flex-col-8 pad-13 lock-gray-dark-blur">
                        <h2>Убежища</h2>
                        <p>Список всех ваших убежищь</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col col-4">
            <div class="flex-col-8">
                <div class="frame">
                    <div class="flex-row-8">
                        <p class="flex-grow">
                            <span>{{ auth()->user()->login }}</span>
                        </p>

                        <form method="POST" action="{{ route('users.logout') }}">
                            @csrf
                            <button class="link font-sm" type="submit">Выйти из аккаунта</button>
                        </form>
                    </div>
                </div>
                <div class="frame">
                    @component('components.datetime', ['container' => auth()->user()])
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection
