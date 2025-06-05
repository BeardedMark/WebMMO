@extends('db.battles.layouts.battle')

@section('battle-content')
    <div class="flex-col-5">
        @component('db.battles.frames.card', compact('battle'))
        @endcomponent

        <div class="frame flex-col-13">
            @foreach ($battle->getLogs() as $log)
            <div class="flex-col">
                <p class="flex-row-5 ai-center color-accent">{{ $log['type'] }} <span class="color-second font-sm">{{ $log['datetime'] }}</span></p>
                <p>{{ $log['message'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
@endsection
