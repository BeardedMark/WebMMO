@extends('db.locations.layouts.location')

@section('top-content')
    <div class="frame flex-row-8 ai-center">
        <p class="flex-grow">
            <span class="color-brand">Бои на локации</span>
        </p>

        <form class="flex" method="POST" action="{{ route('battles.store') }}">
            @csrf
            <input type="hidden" name="type" value="brutal">
            <button class="icon" type="submit" data-tooltip="Создать жестокий бой">
                @component('components.icon', ['size' => 28, 'name' => 'skull', 'color' => 'FFFFFF'])
                @endcomponent
            </button>
        </form>

        <form class="flex" method="POST" action="{{ route('battles.store') }}">
            @csrf
            <input type="hidden" name="type" value="rating">
            <button class="icon" type="submit" data-tooltip="Создать рейтинговый бой">
                @component('components.icon', ['size' => 28, 'name' => 'star--v1', 'color' => 'FFFFFF'])
                @endcomponent
            </button>
        </form>

        <form class="flex" method="POST" action="{{ route('battles.store') }}">
            @csrf
            <input type="hidden" name="type" value="normal">
            <button class="icon" type="submit" data-tooltip="Создать обычный бой">
                @component('components.icon', ['size' => 28, 'name' => 'boxing', 'color' => 'FFFFFF'])
                @endcomponent
            </button>
        </form>

        <a class="icon flex-row-5 ai-center" href="{{ route('battles.create') }}" data-tooltip="Создание новой заявки">
            @component('components.icon', ['size' => 28, 'name' => 'add--v1', 'color' => 'FFFFFF'])
            @endcomponent
        </a>
    </div>
@endsection

@section('mid-content')
    <div class="frame flex-col-8">
        @component('components.header-sm', [
            'header' => 'Открытые бои',
            'note' => 'x' . count($battles),
        ])
        @endcomponent

        @if (count($battles) > 0)
            @component('db.battles.components.list', compact('battles'))
            @endcomponent
        @else
            <p class="font-sm color-second">Нет открытых заявок</p>
        @endif
    </div>

    <div class="frame flex-col-8">
        @component('components.header-sm', [
            'header' => 'Завершенные бои',
            'note' => 'x' . count($finishedBattles),
        ])
        @endcomponent

        @if (count($finishedBattles) > 0)
            @component('db.battles.components.list', ['battles' => $finishedBattles])
            @endcomponent
        @else
            <p class="font-sm color-second">Нет завершенных боёв</p>
        @endif
    </div>
@endsection
