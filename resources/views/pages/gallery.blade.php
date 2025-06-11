@extends('layouts.container')

@section('content')
    <div class="flex-col-8 pad-13">
        <h1 class="color-brand">Галерея изображений</h1>
        <p class="font-lg">Исследуй визуальную атмосферу постцифрового мира</p>
    </div>

    <div class="row g-3">
        @foreach ($images as $img)
            <div class="col-lg-4 col-md-6">
                <a href="{{ $img }}" target="_blink">
                <img src="{{ $img }}" class="img-fluid rounded shadow-sm" alt="{{ $img }}"></a>
            </div>
        @endforeach
    </div>
@endsection
