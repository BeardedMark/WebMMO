@extends('layouts.app')

@section('container')
    <div class="container-fluid mx-auto py-3">
        <div class="flex-col-13">
            <header>
                @include('partials.header')
            </header>

            @yield('content')

            <footer>
                @include('partials.footer')
            </footer>
        </div>
    </div>
@endsection
