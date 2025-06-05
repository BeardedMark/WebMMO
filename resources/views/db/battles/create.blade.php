@extends('db.locations.layouts.location')

@section('mid-content')
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="flex-col-13">
                <form class="frame flex-col-13" method="POST" action="{{ route('battles.store') }}">
                    @csrf

                    <p>Создание заявки на бой</p>

                    <select class="input" name="type" required>
                        @foreach ($battleTypes as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>

                    <div class="flex-row-8 flex ai-center">
                        <button type="submit" class="button">Создать бой</button>
                        <p class="color-second font-sm">или <a class="link font-sm"
                                href="{{ route('battles.index') }}">Отменить</a> создание боя</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
