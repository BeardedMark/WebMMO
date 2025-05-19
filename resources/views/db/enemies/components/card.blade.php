<form action="{{ route('enemies.battle', $enemy->enemy) }}" method="POST">
    @csrf
    <input type="hidden" name="enemy_id" value="{{ $enemy->enemy->id }}">
    <input type="hidden" name="stack" value="{{ $enemy->stack }}">


    <button class="link await relative" type="submit" data-tooltip="Атаковать">
        <img width="55" src="{{ $enemy->enemy->getImageUrl() }}" alt="" style="border-radius: 100%">
        <small class="color-brand absolute text-end fill" style="top: 0; left: 0; z-index; 1">{{ $enemy->stack }}</small>
    </button>
</form>
