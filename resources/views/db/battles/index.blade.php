@extends('db.locations.layouts.location')

@section('top-content')
    {{-- <div class="flex-col-13"> --}}
    <div class="frame flex-row-13 ai-center font-sm">
        <a class="icon flex-row-5 ai-center" href="{{ route('battles.create') }}">
            @component('components.icon', ['size' => 28, 'name' => 'add--v1', 'color' => 'FFFFFF'])
            @endcomponent
        </a>


        {{-- <form method="POST" action="{{ route('battles.store') }}">
                @csrf
                <input type="hidden" name="type" value="normal">
                <button class="link" type="submit">Быстрый</button>
            </form>

            <form method="POST" action="{{ route('battles.store') }}">
                @csrf
                <input type="hidden" name="type" value="rating">
                <button class="link" type="submit">Рейтинговый</button>
            </form>

            <form method="POST" action="{{ route('battles.store') }}">
                @csrf
                <input type="hidden" name="type" value="brutal">
                <button class="link" type="submit">Жестокий</button>
            </form> --}}

        <span class="flex grow"></span>
        <span class="color-second">{{ count($finishedBattles) }} завершено</span>
        <span class="color-brand">{{ count($battles) }} открыто</span>
    </div>
@endsection

@section('mid-content')
    @if (count($battles) > 0)
        <div class="frame flex-col-13">
            <p>Открытые заявки на бой:</p>
            @component('db.battles.components.list', compact('battles'))
            @endcomponent
        </div>
    @endif

    @if (count($finishedBattles) > 0)
        <div class="frame flex-col-13">
            <p>Завершенные бои на локации:</p>
            @component('db.battles.components.list', ['battles' => $finishedBattles])
            @endcomponent
        </div>
    @endif
    {{-- </div> --}}
@endsection

{{-- @section('location-actions')
    <div class="frame flex-col-13">
        <div class="flex-col">
            <form method="POST" action="{{ route('battles.store') }}">
                @csrf
                <button class="link" type="submit">Быстрый бой</button>
            </form>
            <a class="link" href="{{ route('battles.create') }}">Заявка на бой</a>
        </div>

        <div class="flex-col">
            <a class="link lock-gray-dark-blur" href="{{ route('battles.create') }}">Напасть на персонажа</a>
            <a class="link lock-gray-dark-blur" href="{{ route('battles.create') }}">Рейд убежища</a>
        </div>
    </div>
@endsection --}}
