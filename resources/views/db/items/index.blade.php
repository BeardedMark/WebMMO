@extends('layouts.container')

@section('content')
    <div class="flex-col-8 pad-13">
        <h1 class="color-brand">Все предметы в игре</h1>
        <p class="font-lg">Предметы которые можно найти</p>
    </div>

    <div class="frame">
        @component('db.items.components.list', compact('items'))
        @endcomponent
    </div>
@endsection
