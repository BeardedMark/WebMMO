@extends('layouts.fill')
@section('wallpaper', $character->location->getImageUrl())
@section('sound', $character->location->getSoundUrl())

@section('content')
    <div class="row">
        <div class="col col-3 flex-col-5">
            <div id="character-card">
                @component('db.characters.frames.card', compact('character'))
                @endcomponent
            </div>

            <script>
                setInterval(function() {
                    fetch('{{ route('characters.card') }}')
                        .then(response => response.text())
                        .then(html => {
                            const el = document.getElementById('character-card');
                            el.innerHTML = html;
                        });
                }, 1000);
            </script>

            @component('db.characters.frames.equip', compact('character'))
            @endcomponent

            @component('db.characters.frames.stats', compact('character'))
            @endcomponent
        </div>

        <div class="col">
            @yield('character-content')
        </div>
    </div>

    <div class="absolute" style="left: 0; right: 0; bottom: 0;">
        <div class="container-fluid py-3">
            <div class="row justify-content-center">
                <div class="col-6">
                    {{-- @component('db.messages.components.chat', ['currentLocation' => $character->location])
                    @endcomponent --}}

                    <div class="frame" style="max-height: 200px; overflow-x: hidden;">
                        @component('db.characters.frames.logs', compact('character'))
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
