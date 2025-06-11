@extends('layouts.app')

@section('app-content')
    <div class="container mx-auto p-4">
        <div class="flex-col-13">
            @include('partials.header')

            <main class="pad-y-55 flex-col-55">
                <div class="row">
                    <div class="col">
                        <div class="flex-col-55">
                            @yield('content')
                        </div>
                    </div>

                    @hasSection('container-sidebar')
                        <div class="col col-4">
                        <div class="flex-col-13">
                            @yield('container-sidebar')
                        </div>
                        </div>
                    @endif
                </div>
            </main>

            @include('partials.footer')
        </div>
    </div>
@endsection
