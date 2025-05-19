@extends('layouts.hug')

@section('content')
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="flex-col-13">
                    <div class="flex-col-8 pad-13">
                        <h1>Создание персонажа</h1>
                        <p>Введите имя вашего нового персонажа</p>
                    </div>

                    <form class="frame flex-col-13" method="POST" action="{{ route('characters.store') }}">
                        @csrf

                        <div class="flex-col-5">
                            <p>Имя персонажа</p>
                            <input id="name" class="input" type="text" name="name"
                                value="{{ old('name', $location->name ?? '') }}" required autofocus>
                                <p class="color-second font-small">уникальное, от 5 до 20 символов</p>
                        </div>

                        <div class="flex-row-8 flex ai-center">
                            <button type="submit" class="button">Создать персонажа</button>
                            <p class="color-second font-small">или <a class="link font-small"
                                    href="{{ route('users.register') }}">Выбрать</a> из созданных</p>
                        </div>
                    </form>

                    <div class="flex-col-8 pad-13">
                        <p class="color-second font-small">Для избежания блокировки, ознакомтесь <a class="link" href="">правилами</a> создания персонажа</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
