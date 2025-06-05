@extends('layouts.app')

@section('app-content')

    <div class="container-fluid mx-auto py-3">
        <div class="flex-col-13">
            {{-- <header>
                @include('partials.header')
            </header> --}}

            @yield('content')

            <footer>
                @include('partials.footer')
            </footer>
        </div>
    </div>

    {{-- <div class="absolute" style="left: 0; right: 0; bottom: 0;">
        <div class="container-fluid py-3">
            <div class="row justify-content-center">
                <div class="col-6"> --}}
                    {{-- @component('db.messages.components.chat', ['currentLocation' => $character->location])
                    @endcomponent --}}

                    {{-- <div class="frame">
                        @component('db.characters.frames.logs', ['character' => auth()->user()->currentCharacter()])
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
