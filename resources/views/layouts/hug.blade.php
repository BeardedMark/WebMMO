@extends('layouts.app')

@section('app-content')

<div class="container mx-auto p-4">
    <div class="flex-col-13">
        <header class="frame">
            @include('partials.header')
        </header>

        <main class="pad-y-55 flex-col-55">
            @yield('content')
        </main>

        <footer class="frame">
            @include('partials.footer')
        </footer>
    </div>
</div>
@endsection
