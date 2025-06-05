@extends('layouts.hug')

@section('content')
    <div class="row">
        <div class="col">
            <div class="flex-col-13">
                <div class="flex-col-8 pad-13">
                    <h1>Все персонажи игроков</h1>
                    <p>Персонажи других игроков, которых вы може встретить</p>
                </div>

                <div class="row g-4">
                    @foreach ($characters as $character)
                        <div class="col-4">
                            @component('db.characters.frames.card', compact('character'))
                            @endcomponent
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
