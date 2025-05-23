@extends('layouts.app')

@section('container')

<div class="container mx-auto p-4">
    <div class="flex-col-13">
        <header>
            @include('partials.header')
        </header>

        <main class="section">
            @yield('content')
        </main>

        <footer>
            @include('partials.footer')
        </footer>
    </div>
</div>
@endsection
