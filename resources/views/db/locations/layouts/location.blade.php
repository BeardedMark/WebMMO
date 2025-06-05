@extends('db.characters.layouts.character')

@section('left-context')
    @component('db.locations.components.card', ['location' => $character->location])
    @endcomponent

    <div class="frame flex-col-13">
        <p class="font-sm" data-tooltip="При посещении местности">Эффекты на местности</p>


        @if ($character->transition->hasModifiers())
            @component('db.modifiers.frames.modifiers', ['modifiers' => $character->transition->getModifierInstances()])
            @endcomponent
        @else
            <p class="color-second">Нет эффектов местности</p>
        @endif
    </div>

    <span data-tooltip="Это пример подсказки">🛈 Наведи на меня</span>

</p>
@endsection
