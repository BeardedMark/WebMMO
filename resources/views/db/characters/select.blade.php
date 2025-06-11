@extends('layouts.container')

@section('content')
    <div class="row">
        <div class="col">
            <div class="flex-col-13">
                <div class="flex-col-8 pad-13">
                    <h1>Выбор персонажа</h1>
                    <p>Персонажи других игроков, которых вы може встретить</p>
                </div>

                <div class="row g-4">
                    @foreach ($user->characters as $character)
                        <div class="col-4">
                            <div class="flex-col-13">
                                @component('db.characters.frames.card', compact('character'))
                                @endcomponent

                                <form class="flex-col" action="{{ route('characters.selected', $character) }}" method="POST">
                                    @csrf
                                    <button class="button" type="submit">Выбрать</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
