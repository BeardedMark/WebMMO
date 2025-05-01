@extends('layouts.hug')
@section('wallpaper', $location->getImageUrl())
@section('sound', $location->getSoundUrl())

@section('content')
    <div class="flex-col-13">
        <h1>Создание убежища на локации</h1>

        <form class="frame flex-col-13" method="POST" action="{{ route('hideouts.store') }}">
            @csrf
            <div class="flex-col">
                <label class="form-label">Название убежища</label>
                <input type="text" name="name" class="input form-control" value="{{ old('name', $hideout->name ?? '') }}"
                    required>
            </div>

            <div class="flex-row-8 flex ai-center">
                <button type="submit" class="button">Создать убежище</button>
            </div>
        </form>
    </div>
@endsection
