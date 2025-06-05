@extends('layouts.app')

@section('app-content')
    <div class="container-fluid pad-13" style="height: 100vh">
        <div class="flex-col-13 h-100">
            <div class="row">
                <div class="col-3">
                    <div class="frame flex-row-13 ai-center">
                        <a class="icon" href="{{ route('pages.main') }}">
                            @component('components.icon', ['size' => 28, 'name' => 'menu--v1', 'color' => 'FFFFFF'])
                            @endcomponent
                        </a>
                        <a class="link font-sm" href="{{ route('pages.main') }}">Remnants of the Future</a>

                        <div class="flex grow jc-end flex-row-13">
                            <a class="icon" href="{{ route('transitions.index') }}">
                                @component('components.icon', ['size' => 28, 'name' => 'adventure', 'color' => 'FFFFFF'])
                                @endcomponent
                            </a>

                            <a class="icon" href="{{ route('transitions.show', $character->transition) }}">
                                @component('components.icon', ['size' => 28, 'name' => 'place-marker', 'color' => 'FFFFFF'])
                                @endcomponent
                            </a>

                            <a class="icon" href="{{ route('battles.index') }}">
                                @component('components.icon', ['size' => 28, 'name' => 'battle', 'color' => 'FFFFFF'])
                                @endcomponent
                            </a>

                            <a class="icon lock-gray-dark-blur" href="{{ route('battles.index') }}">
                                @component('components.icon', ['size' => 28, 'name' => 'bonfire', 'color' => 'FFFFFF'])
                                @endcomponent
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    @yield('top-content')
                </div>

                <div class="col-3">
                    <div class="frame flex-row-13">
                        <div class="flex grow flex-row-13">
                            <a class="icon" href="{{ route('characters.inventory') }}">
                                @component('components.icon', ['size' => 28, 'name' => 'rucksack', 'color' => 'FFFFFF'])
                                @endcomponent
                            </a>

                            <a class="icon lock-gray-dark-blur" href="">
                                @component('components.icon', ['size' => 28, 'name' => 'creativity', 'color' => 'FFFFFF'])
                                @endcomponent
                            </a>

                            <a class="icon lock-gray-dark-blur" href="">
                                @component('components.icon', ['size' => 28, 'name' => 'magical-scroll', 'color' => 'FFFFFF'])
                                @endcomponent
                            </a>

                            <a class="icon lock-gray-dark-blur" href="">
                                @component('components.icon', ['size' => 28, 'name' => 'address-book-2', 'color' => 'FFFFFF'])
                                @endcomponent
                            </a>
                        </div>

                        @component('db.transitions.components.timer', compact('character'))
                        @endcomponent

                        <a class="icon" href="{{ route('users.main') }}">
                            @component('components.icon', ['size' => 28, 'name' => 'user-male-circle', 'color' => 'FFFFFF'])
                            @endcomponent
                        </a>
                    </div>
                    @yield('right-navigate')
                </div>
            </div>

            <div class="row h-100">
                <div id="left-context" class="col-3">
                    <div class="flex-col-8">
                        @yield('left-context')
                        @stack('left-sidebar')
                    </div>
                </div>

                <div class="col">

                    <div class="flex-col-8 flex grow h-100">
                        @hasSection('mid-content')
                            <div class="row">
                                <div id="mid-content" class="col-12">
                                <div class="flex-col-8">
                                    @yield('mid-content')
                                </div></div>
                            </div>
                        @endif

                        <div class="row h-100" style="max-height: 100%">
                            <div id="left-content" class="col-6">
                                <div class="flex-col-8">
                                    @yield('left-content')
                                </div>
                            </div>
                            <div id="right-content" class="col-6">
                                <div class="flex-col-8">
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

                <div id="right-context" class="col-3">
                    <div class="flex-col-8">
                        @yield('right-context')
                        @stack('right-sidebar')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
