@extends('db.characters.inventory')

@section('left-content')
    <div class="frame flex-col-13">
        @component('components.header-sm', [
            'header' => 'Эффекты от экипировки',
            'note' => 'x' . count($character->getEquipmentModifiers()),
        ])
        @endcomponent

        <div class="color-second">
            @if (count($character->getEquipmentModifiers()) > 0)
                @foreach ($character->getEquipmentModifiers() as $mod)
                    @component('components.stat', ['name' => $mod->getName(), 'value' => $mod->getValueTitle()])
                    @endcomponent
                @endforeach
            @else
                <p class="color-second font-sm">Нет экипированных предметов</p>
            @endif
        </div>
    </div>
@endsection
