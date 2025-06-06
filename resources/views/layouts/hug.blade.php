@extends('layouts.app')

@section('app-content')
    <div class="container mx-auto p-4">
        <div class="flex-col-13">
            @include('partials.header')

            <main class="pad-y-55 flex-col-55">
                @yield('content')
            </main>

            @include('partials.footer')
        </div>
    </div>
@endsection
