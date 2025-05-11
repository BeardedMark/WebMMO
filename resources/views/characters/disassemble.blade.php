@extends('characters.layouts.inventory')

@section('inventory-content')
<div class="frame flex-col-13">
    @if (count($currentCharacter->getDisassembleItems($currentCharacter->getLevel())) > 0)
        <div class="flex-col">
            @foreach ($currentCharacter->getDisassembleItems($currentCharacter->getLevel()) as $item)
                @component('items.components.disassemble', [
                    'item' => $item,
                    'fromContainer' => $currentCharacter->getTable(),
                    'fromId' => $currentCharacter->id,
                ])
                @endcomponent
            @endforeach
        </div>
    @endif
</div>
@endsection
