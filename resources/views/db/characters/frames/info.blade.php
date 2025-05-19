<div class="frame flex-col-13">
    <div>
        @component('components.stat', [
            'name' => 'Пользователь',
            'value' => $character->user->getTitle(),
            'link' => route('users.show', $character->user),
        ])
        @endcomponent
        @component('components.stat', [
            'name' => 'Локация',
            'value' => $character->currentLocation()->getTitle(),
            'link' => route('locations.show', $character->currentLocation()),
        ])
        @endcomponent
    </div>

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

    <div>
        @component('components.datetime', ['entity' => $character])
        @endcomponent
    </div>
</div>
