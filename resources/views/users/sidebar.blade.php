@extends('layouts.hug')

@section('content')
    <div class="row">
        <div class="col">
            @yield('user-content')
        </div>

        <div class="col col-4">
            <div class="frame">
                @component('users.components.link', ['user' => auth()->user()])

                @endcomponent
            </div>

            <div class="frame flex-col-8">
                <a class="link" href="{{ route('characters.create') }}">Создать персонажа</a>
                <a class="link" href="{{ route('characters.select') }}">Выбрать персонажа</a>
                <a class="link" href="{{ route('users.show', auth()->user()) }}">Публичный профиль</a>
                <form method="POST" action="{{ route('users.logout') }}">
                    @csrf
                    <button type="submit" class="link">Выйти из аккаунта</button>
                </form>
            </div>
        </div>
    </div>
@endsection
