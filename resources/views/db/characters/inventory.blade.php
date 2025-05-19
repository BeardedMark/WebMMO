@extends('db.characters.layouts.inventory')

@section('inventory-content')
    <div class="row jc-center">
        <div class="col col-6">
            @component('db.items.components.inventory', [
                'fromContainer' => $character,
                'toContainer' => $character->transition,
            ])
            @endcomponent
        </div>

        <div class="col col-6">
            @component('db.items.components.inventory', [
                'fromContainer' => $character,
                'toContainer' => $character->transition,
            ])
            @endcomponent
        </div>
    </div>
@endsection
