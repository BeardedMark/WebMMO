<div class="row g-0">
    <div class="col">
        <div class="frame flex-col-8">
            @component('messages.components.list', ['messages' => $currentLocation->messages])
            @endcomponent
        </div>

        @component('messages.components.input')
        @endcomponent
    </div>

    <div class="col-4">
        <div class="frame h-100">
            <div class="flex-col">
                @foreach ($currentLocation->charactersOnLocation() as $character)
                    <small class="flex-row-8">
                        <span class="flex grow">
                            @component('characters.components.line', compact('character'))
                            @endcomponent
                        </span>
                    </small>
                @endforeach
            </div>
        </div>
    </div>
</div>
