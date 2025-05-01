@extends('layouts.hug')

@section('content')
    <div class="flex-col-13">
        <h1>Создание нового персонажа</h1>
        <form class="frame flex-col-13" method="POST" action="{{ route('characters.store') }}">
            @csrf
            @include('characters.components.form')
            <div class="flex-row-8 flex ai-center">
                <button type="submit" class="button">Создать персонажа</button>
            </div>
        </form>
    </div>
@endsection
