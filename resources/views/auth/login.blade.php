@extends('layouts.hug')

@section('content')
    <div class="flex-col-13">
        <h1>Авторизация</h1>

        <div class="frame">
            @component('auth.components.login')
            @endcomponent
        </div>
    </div>
@endsection
