@extends('layouts.hug')

@section('content')
    <div class="flex-col-13">
        <div class="flex-col">
            <h1>Все персонажи</h1>
            <div class="flex-row-8">
                <a class="button" href="{{ route('characters.create') }}">Создать персонажа</a>
            </div>
        </div>

        <div class="frame flex-col">
            @component('characters.components.list', compact('characters'))
            @endcomponent
        </div>

    </div>
@endsection
