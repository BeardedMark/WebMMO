<div class="frame flex-col-13">
    <p class="color-second">Пользователь</p>
    <a class="link" href="{{ route('users.show', $character->user) }}">{{ $character->user->getTitle() }}</a>

    <div>
        @component('components.stat', [
            'name' => 'Дата создания',
            'value' => $character->created_at,
        ])
        @endcomponent
        @component('components.stat', [
            'name' => 'Дата изменения',
            'value' => $character->updated_at,
        ])
        @endcomponent
        @isset($character->deleted_at)
            @component('components.stat', [
                'name' => 'Дата удаления',
                'value' => $character->deleted_at,
            ])
            @endcomponent
        @endisset
    </div>

    <p class="color-second">Локация</p>

    @component('locations.components.line', ['location' => $character->currentLocation()])
    @endcomponent

    <div>
        @component('components.stat', [
            'name' => 'Время задержки на локации',
            'value' => $character->timeToNextAction() . ' сек',
        ])
        @endcomponent
        @component('components.stat', [
            'name' => 'Время нахождения на локации',
            'value' => $character->timeOnCurrentLocation() . ' сек',
        ])
        @endcomponent
    </div>
</div>
