@extends('users.sidebar')

@section('user-content')
    <div class="frame flex-col-13">
        <h1 class="color-brand">Создание персонажа</h1>
        <p>Придумайте и введите имя вашего нового персонажа</p>

        <form class="flex-col-13" method="POST" action="{{ route('characters.store') }}">
            @csrf

            <input id="name" class="input" type="text" name="name" placeholder="Имя персонажа"
                value="{{ old('name', $location->name ?? '') }}" required autofocus>

            <div class="flex-row-8 flex jc-end ai-center">
                <button type="submit" class="button">Создать персонажа</button>
            </div>
        </form>
    </div>
@endsection
