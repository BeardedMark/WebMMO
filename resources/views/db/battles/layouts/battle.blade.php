@extends('layouts.gameplay')
@section('wallpaper', $character->location->getImageUrl())
@section('sound', $character->location->getSoundUrl())
@php
    $self = $character;
    $creator = $battle->getCreator();
    $opponent = $battle->getOpponent();

    // Текущий пользователь — это создатель?
    if ($creator->id === $self->id) {
        $leftCharacter = $opponent;
        $rightCharacter = $creator;
    } else {
        $leftCharacter = $creator;
        $rightCharacter = $opponent ?? $self;
    }
@endphp


@section('mid-content')
    @yield('battle-content')
@endsection
@section('left-context')
    @if ($leftCharacter)
        @component('db.characters.frames.card', ['character' => $leftCharacter])
        @endcomponent
    @else
        <p class="frame">Ожидание оппонента...</p>
    @endif
@endsection

@section('right-context')
    @if ($rightCharacter)
        @component('db.characters.frames.card', ['character' => $rightCharacter])
        @endcomponent
    @endif
@endsection
