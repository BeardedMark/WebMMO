@extends('layouts.hug')
@section('wallpaper', $character->currentLocation()->getImageUrl())

@section('content')

    <div class="row">
        <div class="col">
            @component('characters.frames.stats', compact('character'))
            @endcomponent
        </div>

        <div class="col col-4">
            @component('characters.components.card', compact('character'))
            @endcomponent

            @component('characters.frames.info', compact('character'))
            @endcomponent
        </div>

    </div>
@endsection
