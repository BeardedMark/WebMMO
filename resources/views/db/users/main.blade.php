@extends('layouts.hug')

@section('content')
    <div class="row">
        <div class="col">
    <div class="flex-col">
        <div class="flex-col-8 pad-13">
                <h1>Личный кабинет</h1>
                <p>Страница управления вашим профилем на сайте</p>

            <p class="color-second font-small">Тут вы сможете найти функционал доступный персонально вам</p>
            <p>Вы авторизованы как: <a class="link" href="">{{ auth()->user()->login }}</a></p>

            <div class="flex-row-8 font-small">
                <a class="link font-small" href="{{ route('users.show', auth()->user()) }}">Публичный профиль</a>
                <p class="color-second">или</p>
                <form method="POST" action="{{ route('users.logout') }}">
                    @csrf
                    <button class="link" type="submit">Выйти из аккаунта</button>
                </form>
            </div>
        </div>

        <div class="flex-col-8 pad-13">
            <h2>Ваши персонажи</h2>

            <div class="flex-row-8 font-small">
                <a class="link" href="{{ route('characters.select') }}">Сменить персонажа</a>
                <p class="color-second">или</p>
                <a class="link" href="{{ route('characters.create') }}">Создать нового</a>
            </div>
        </div>
    </div>
        </div>

        <div class="col col-4">
        </div>
    </div>
@endsection
