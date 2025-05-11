@extends('characters.layouts.sidebar')

@section('character-content')
    <div class="row">
        <div class="col col-4">
            <div class="frame flex-col">
                <a class="link" href="{{ route('characters.inventory') }}">Предметы в инвентаре</a>
                <a class="link" href="{{ route('characters.craft') }}">Создать предмет</a>
                <a class="link" href="{{ route('characters.disassemble') }}">Разобрать предмет</a>
            </div>
        </div>

        <div class="col">
            @yield('inventory-content')
        </div>
    </div>
@endsection
