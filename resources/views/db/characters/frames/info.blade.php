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
            'name' => 'Время задержки',
            'value' => $character->timeToNextAction() . ' сек',
        ])
        @endcomponent
        @component('components.stat', [
            'name' => 'Время на локации',
            'value' => $character->timeOnCurrentLocation() . ' сек',
        ])
        @endcomponent
    </div>

    <div>
        @component('components.stat', ['name' => 'Последняя активность', 'value' => $character->getActivityAt()])
        @endcomponent

        @component('components.datetime', ['container' => $character])
        @endcomponent
    </div>
</div>
