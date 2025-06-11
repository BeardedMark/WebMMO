@extends('db.locations.layouts.location')

@section('top-content')
    <div class="frame flex-row-8 ai-center">
        <p class="flex-grow">
            <span class="color-brand">Инвентарь персонажа</span>
        </p>

        <a class="icon flex-row-5 ai-center" href="{{ route('characters.stats') }}" data-tooltip="Показатели персонажа">
            @component('components.icon', ['size' => 28, 'name' => 'resume', 'color' => 'FFFFFF'])
            @endcomponent
        </a>

        <a class="icon flex-row-5 ai-center" href="{{ route('characters.craft') }}" data-tooltip="Создание предметов">
            @component('components.icon', ['size' => 28, 'name' => 'full-tool-storage-box-', 'color' => 'FFFFFF'])
            @endcomponent
        </a>
    </div>
@endsection

@section('right-content')
    <div class="frame flex-col-13">
        @component('components.header-sm', [
            'header' => 'Предметы в инвентаре',
            'note' => 'x' . count($character->getItems()),
        ])
        @endcomponent

        @component('db.items.components.inventory', [
            'fromContainer' => $character,
            'toContainer' => $character->transition,
        ])
        @endcomponent
    </div>
@endsection

@section('left-content')
    <div class="frame flex-col-13">
        @component('components.header-sm', [
            'header' => 'Предметы на местности',
            'note' => 'x' . count($character->transition->getItems()),
        ])
        @endcomponent

        @if (count($character->transition->getItems()) > 0)
            @component('db.items.components.inventory', [
                'fromContainer' => $character->transition,
                'toContainer' => $character,
            ])
            @endcomponent
        @else
            <p class="color-second">Ничего не найдено</p>
        @endif
    </div>
@endsection
