@extends('layouts.hug')

@section('content')
    <div class="flex-col-13">
        <h1>Добро пожаловать, {{ Auth::user()->login ?? 'Гость' }}!</h1>

        @if (auth()->check())
            <div class="frame flex-col-13">
                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <a class="button" href="{{ route('users.show', auth()->user()) }}">Мой профиль</a>
                    <a class="button" href="{{ route('characters.select') }}">Выбрать персонажа</a>
                    <button type="submit" class="button">Выйти из аккаунта</button>
                </form>
            </div>
        @else
            <div class="row">
                <div class="col">
                    <div class="frame">
                        <p class="link">Вход</p>
                        @component('auth.components.login')
                        @endcomponent
                    </div>
                </div>

                <div class="col">
                    <div class="frame">
                        <p class="link">Регистрация</p>
                        @component('auth.components.register')
                        @endcomponent
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
