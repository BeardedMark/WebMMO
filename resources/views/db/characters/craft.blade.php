@extends('db.characters.layouts.inventory')

@section('inventory-content')
    <div class="frame flex-col-13">
        @if (count($character->getAvailableCrafts($character->getLevel())) > 0)
            <div class="flex-col">
                @foreach ($character->getAvailableCrafts($character->getLevel()) as $availableCraftItem)
                    @component('db.items.components.assemble', [
                        'item' => $availableCraftItem,
                        'fromContainer' => $character->getTable(),
                        'fromId' => $character->id,
                    ])
                    @endcomponent
                @endforeach
            </div>
        @endif
    </div>
@endsection
