@extends('layouts.hug')

@section('content')
<div class="row">
    <div class="col">
        <div class="flex-col-13">
            <div class="flex-col-8 pad-13">
                <h1>Все персонажи игроков</h1>
                <p>Персонажи других игроков, которых вы може встретить</p>
            </div>

            @component('db.characters.components.grid', compact('characters'))
            @endcomponent
        </div>
    </div>
</div>
@endsection
