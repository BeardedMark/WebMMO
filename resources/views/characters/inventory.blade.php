@extends('characters.layouts.inventory')

@section('inventory-content')
    @component('items.components.inventory', [
        'fromContainer' => $currentCharacter,
        'toContainer' => $currentTransition,
    ])
    @endcomponent
@endsection
