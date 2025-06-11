@extends('db.characters.layouts.character')
@section('wallpaper', $character->location->getImageUrl())
@section('sound', $character->location->getSoundUrl())

@section('left-context')
    <div class="frame flex-row-8 ai-center">
        <a class="icon" href="{{ route('pages.main') }}" data-tooltip="Главная страница">
            @component('components.icon', ['size' => 28, 'name' => 'menu--v1', 'color' => 'FFFFFF'])
            @endcomponent

            {{-- <div class="img-contain" style="height: 28px">
                <img src="{{ asset('storage/images/favicon.png') }}" alt="logo">
            </div> --}}
        </a>

        <p class="color-second" data-tooltip="Выживи на руинах идеального будущего">
            RemFut
        </p>

        <div class="flex-grow jc-end flex-row-8">
            <a class="icon" href="{{ route('transitions.index') }}" data-tooltip="Карта локаций">
                @component('components.icon', ['size' => 28, 'name' => 'adventure', 'color' => 'FFFFFF'])
                @endcomponent
            </a>

            <a class="icon" href="{{ route('transitions.show', $character->transition) }}"
                data-tooltip="Местность на локации">
                @component('components.icon', ['size' => 28, 'name' => 'place-marker', 'color' => 'FFFFFF'])
                @endcomponent
            </a>

            <a class="icon" href="{{ route('battles.index') }}" data-tooltip="Бои на локации">
                @component('components.icon', ['size' => 28, 'name' => 'battle', 'color' => 'FFFFFF'])
                @endcomponent
            </a>

            <a class="icon lock-gray-dark-blur" href="{{ route('battles.index') }}">
                @component('components.icon', ['size' => 28, 'name' => 'home-page', 'color' => 'FFFFFF'])
                @endcomponent
            </a>
        </div>
    </div>

    @component('db.locations.components.card', ['location' => $character->location])
    @endcomponent

    <div class="frame flex-col-8">
        @component('components.header-sm', [
            'header' => 'Эффекты на местности',
            'note' => 'x' . count($character->transition->getModifierInstances()),
            'tooltip' => 'Влияют на персонажа, контент и на созданные бои',
        ])
        @endcomponent

        @if ($character->transition->hasModifiers())
            <div class="flex-col font-sm">
                @component('db.modifiers.frames.modifiers', ['modifiers' => $character->transition->getModifierInstances()])
                @endcomponent
            </div>
        @else
            <p class="color-second font-sm">
                <span data-tooltip="Переобойдите локацию обновив местность">Нет эффектов местности</span>
            </p>
        @endif
    </div>
@endsection
