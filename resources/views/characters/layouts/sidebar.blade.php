@extends('layouts.fill')
@section('wallpaper', $currentLocation->getImageUrl())
@section('sound', $currentLocation->getSoundUrl())

@section('content')
    <div class="row">
        <div class="col">
            @yield('character-content')
        </div>

        <div class="col col-3">
            @component('characters.components.card', ['character' => $currentCharacter])
            @endcomponent

            <div class="frame">
                @component('characters.frames.logs', ['character' => $currentCharacter])
                @endcomponent
            </div>

            {{-- @component('characters.frames.equip', ['character' => $currentCharacter])
            @endcomponent --}}

        </div>
    </div>

    {{-- <div class="absolute" style="left: 0; right: 0; bottom: 0;">
        <div class="frame" style="max-height: 200px; overflow-x: hidden;">
            @component('characters.frames.logs', ['character' => $currentCharacter])
            @endcomponent
        </div>
    </div> --}}

    {{-- <div class="absolute" style="left: 0; right: 0; bottom: 0;">
        <div class="container-fluid">
            @component('messages.components.chat', ['currentLocation' => $currentLocation])
            @endcomponent
        </div>
    </div> --}}
@endsection
