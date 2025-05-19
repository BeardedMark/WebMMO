@extends('layouts.hug')

@section('content')
    <div class="row">
        <div class="col">
            <div class="flex-col-13">
                <div class="flex-col-8 pad-13">
                    <h1>Выбор персонажа</h1>
                    <p>Персонажи других игроков, которых вы може встретить</p>
                </div>
                <div class="row">

                    @foreach ($user->characters as $character)
                        <div class="col-4">
                            <form class="flex-col-8" action="{{ route('characters.selected', $character) }}" method="POST">
                                @csrf
                                @component('db.characters.frames.card', compact('character'))
                                @endcomponent

                                @component('db.characters.frames.stats', compact('character'))
                                @endcomponent

                                <button class="button" type="submit">Выбрать</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
