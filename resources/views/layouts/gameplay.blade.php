@extends('layouts.app')

@section('app-content')
    {{-- <audio id="bg-audio" autoplay loop>
        <source src="@yield('sound')" type="audio/mpeg">
    </audio>

    <script>
        const audio = document.getElementById('bg-audio');
        audio.volume = 0.1;
    </script> --}}

    <div class="container-fluid pad-13" style="height: 100vh">
        <div class="row g-4 h-100">
            <div id="left-context" class="col-12 col-sm-6 col-xl-3 order-1 order-xl-1">
                <div class="flex-col-13">
                    @yield('left-context')
                </div>
            </div>

            <div class="col-12 col-xl-6 order-3 order-xl-2">
                <div class="flex-col-13 flex-grow h-100">
                    @hasSection('top-content')
                        <div class="row">
                            <div id="top-content" class="col-12">
                                <div class="flex-col-8">
                                    @yield('top-content')
                                </div>
                            </div>
                        </div>
                    @endif

                    @hasSection('mid-content')
                        <div class="row">
                            <div id="mid-content" class="col-12">
                                <div class="flex-col-13">
                                    @yield('mid-content')
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row h-100" style="max-height: 100%">
                        <div id="left-content" class="col-6">
                            <div class="flex-col-13">
                                @yield('left-content')
                            </div>
                        </div>

                        <div id="right-content" class="col-6">
                            <div class="flex-col-13">
                                @yield('right-content')
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div id="bot-content" class="col-12">
                            <div class="frame">
                                @component('db.characters.frames.logs', ['character' => $character])
                                @endcomponent
                            </div>
                        </div>

                        @hasSection('bot-content')
                            <div id="bot-content" class="col-12">@yield('bot-content')</div>
                        @endif
                    </div>
                </div>
            </div>

            <div id="right-context" class="col-12 col-sm-6 col-xl-3 order-2 order-xl-3">
                <div class="flex-col-13">
                    @yield('right-context')
                </div>
            </div>
        </div>
    </div>
@endsection
