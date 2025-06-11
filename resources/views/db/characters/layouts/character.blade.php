@extends('layouts.gameplay')

@section('right-context')
    <div class="frame flex-row-8 ai-center">
        <div class="flex-grow flex-row-8">
            <a class="icon" href="{{ route('characters.inventory') }}" data-tooltip="Инвентарь персонажа">
                @component('components.icon', ['size' => 28, 'name' => 'rucksack', 'color' => 'FFFFFF'])
                @endcomponent
            </a>

            <a class="icon lock-gray-dark-blur" data-tooltip="Навыки персонажа">
                @component('components.icon', ['size' => 28, 'name' => 'creativity', 'color' => 'FFFFFF'])
                @endcomponent
            </a>

            <a class="icon lock-gray-dark-blur" href="" data-tooltip="Задания персонажа">
                @component('components.icon', ['size' => 28, 'name' => 'magical-scroll', 'color' => 'FFFFFF'])
                @endcomponent
            </a>

            <a class="icon lock-gray-dark-blur" href="" data-tooltip="Контакты персонажа">
                @component('components.icon', ['size' => 28, 'name' => 'address-book-2', 'color' => 'FFFFFF'])
                @endcomponent
            </a>
        </div>

        <p class="color-second">{{ auth()->user()->getTitle() }}</p>

        <a class="icon" href="{{ route('users.main') }}" data-tooltip="Личный кабинет">
            @component('components.icon', ['size' => 28, 'name' => 'user-male-circle', 'color' => 'FFFFFF'])
            @endcomponent
        </a>
    </div>

    @component('db.characters.frames.card', compact('character'))
    @endcomponent

    @if ($character->currentBattle())
        @component('db.battles.frames.card', ['battle' => $character->currentBattle()])
        @endcomponent
    @endif

    <div class="frame flex-col-8">
        @component('components.header-sm', [
            'header' => 'Временные эффекты',
            'note' => 'x0',
            'tooltip' => 'Усиления и ослабления персонажа',
        ])
        @endcomponent

        <p class="color-second font-sm">
            <span data-tooltip="Использование предметов, получение травм">
                Нет временных эффектов
            </span>
        </p>
    </div>
@endsection
