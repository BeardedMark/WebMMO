@extends('layouts.fill')
@section('wallpaper', $location->getImageUrl())
@section('sound', $location->getSoundUrl())

@section('content')
<div class="flex-col-8">
    <h1>
        {{ $hideout->getTitle() }}</h1>

    <div class="row">
        <div class="col">
            <div class="flex-col-13">
                <div class="frame">

                    <div class="flex-col">
                        <span>Пользователь: {{ $hideout->user->login }}</span>
                        <span>Локация: {{ $hideout->location->getTitle() }}</span>
                        <span>Предметов: {{ $hideout->getTotalItemsCount() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            @component('db.items.components.inventory', [
                'fromContainer' => $hideout,
                'toContainer' => $character,
            ])
            @endcomponent
        </div>

        <div class="col">
            @component('db.items.components.inventory', [
                'fromContainer' => $character,
                'toContainer' => $hideout,
            ])
            @endcomponent
        </div>
    </div>
</div>
@endsection
