<form class="row g-1" action="{{ route('enemies.battle', $enemy->enemy) }}" method="POST" class="flex items-center gap-2">
    @csrf
    @isset($enemy->enemy)
        <input type="hidden" name="enemy_id" value="{{ $enemy->enemy->id }}">
    @endisset

    <div class="col">
        @component('enemies.components.link', ['enemy' => $enemy->enemy])
        @endcomponent
    </div>

    <div class="col-3">
        <span class="color-second">{{ $enemy->enemy->danger }} сл</span>
    </div>

    <div class="col-3">
        <input class="link" type="number" name="stack" value="{{ $enemy->stack }}" min="1"
            max="{{ $enemy->stack }}" class="w-16 text-center">
    </div>

    <div class="col-auto await">
        <button class="icon" type="submit" data-tooltip="Атаковать">
            @component('components.icon', ['size' => 21, 'name' => 'define-location', 'color' => 'BAC7E3'])
            @endcomponent
        </button>
    </div>
</form>
