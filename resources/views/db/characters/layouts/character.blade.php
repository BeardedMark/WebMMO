@extends('layouts.gameplay')
@section('wallpaper', $character->location->getImageUrl())
@section('sound', $character->location->getSoundUrl())

@section('right-context')
    @component('db.characters.frames.card', compact('character'))
    @endcomponent

    @if ($character->currentBattle())
        @component('db.battles.frames.card', ['battle' => $character->currentBattle()])
        @endcomponent
    @endif

    <div class="frame flex-col-13">
        <p class="color-second font-sm">Нет временных эффектов</p>
    </div>
@endsection
