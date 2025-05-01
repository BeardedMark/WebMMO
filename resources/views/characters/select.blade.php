@extends('layouts.hug')

@section('content')
    <div class="flex-col-13">
        <div class="flex-col">
            <h1>Выбор персонажа</h1>
            <div class="flex-row-8">
                <a class="button" href="{{ route('characters.create') }}">Создать нового персонажа</a>
            </div>
        </div>

        <div class="frame flex-col">
            @foreach ($user->characters as $character)
            <form action="{{ route('characters.selected', $character) }}" method="POST">
                @csrf
                <button class="link" type="submit">{{ $character->getTitle() }}</button>
            </form>
            @endforeach
        </div>
    </div>
@endsection
