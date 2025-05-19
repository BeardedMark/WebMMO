<div class="flex-col">

    <div class="flex-row">
        <a class="button lock-opacity" href="{{ route('transitions.index') }}">Глобальный</a>
        <a class="button" href="{{ route('transitions.index') }}">Локация</a>
        <a class="button lock-opacity" href="{{ route('transitions.index') }}">Область</a>
        <a class="button lock-opacity" href="{{ route('transitions.index') }}">Группы</a>
        <a class="button lock-opacity" href="{{ route('characters.inventory') }}">Личные</a>
        <a class="button lock-opacity" href="{{ route('characters.inventory') }}">История</a>
    </div>

    <div class="row g-0">

        <div class="col-4">
            <div class="frame h-100">
                <div class="flex-col">
                    @foreach ($currentLocation->charactersOnLocation() as $character)
                        <small class="flex-row-8">
                            <span class="flex grow">
                                @component('db.characters.components.line', compact('character'))
                                @endcomponent
                            </span>
                        </small>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col">
            <div class="frame flex-col-8">
                @component('db.messages.components.list', ['messages' => $currentLocation->messages])
                @endcomponent
            </div>

            @component('db.messages.components.input')
            @endcomponent
        </div>
    </div>

</div>
