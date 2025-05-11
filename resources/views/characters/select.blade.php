@extends('users.sidebar')

@section('user-content')
    <div class="frame flex-col-13">
        <h1 class="color-brand">Выбор персонажа</h1>

        <div>
            @foreach ($user->characters as $character)
                <form class="flex-row-8" action="{{ route('characters.selected', $character) }}" method="POST">
                    @csrf
                    @component('characters.components.line', compact('character'))
                    @endcomponent

                    <button class="link" type="submit">Выбрать</button>
                </form>
            @endforeach
        </div>
    </div>
@endsection
