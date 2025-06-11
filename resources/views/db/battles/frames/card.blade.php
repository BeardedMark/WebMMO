@php
    $self = auth()->user()->currentCharacter();
    $isFinished = !is_null($battle->winner_id);
    $isCreator = $self->id === $battle->creator_id;
    $isOpponent = $self->id === $battle->opponent_id;
    $hasOpponent = !is_null($battle->opponent_id);
    $isParticipant = $isCreator || $isOpponent;
    $canJoin = !$isParticipant && !$hasOpponent && !$self->inBattle();
@endphp

<div class="frame flex-col-13">
    <div class="flex-col">
        <p class="flex-row-5 ai-center">
            <a class="link" href="{{ route('battles.show', $battle) }}">{{ $battle->getTitle() }} бой</a>

            <span class="flex-grow"></span>

            <span
                class="flex color-{{ $battle->hasWinner() ? 'second' : ($battle->hasOpponent() ? 'warning' : 'success') }} font-sm text-end">{{ $battle->getStatus() }}</span>
        </p>

        <p class="color-second">
            @component('db.characters.components.link', ['character' => $battle->getCreator()])
            @endcomponent

            @if ($battle->hasOpponent())
                @if ($battle->hasWinner())
                    @if ($battle->getWinner() == $battle->getCreator())
                        победил
                    @else
                        проиграл
                    @endif
                @endif
                против
                @component('db.characters.components.link', ['character' => $battle->getOpponent()])
                @endcomponent
            @else
                ждет соперника
            @endif
        </p>
    </div>

    @if (!$isFinished)
        <div class="flex-row-5 ai-center color-second font-sm">
            {{-- Действия по ролям, если бой не завершён --}}
            @if ($isCreator)
                @if ($hasOpponent)
                    <form method="POST" action="{{ route('battles.confirm', $battle) }}">
                        @csrf
                        <button class="button" type="submit">Подтвердить бой</button>
                    </form>

                    <form method="POST" action="{{ route('battles.reject', $battle) }}">
                        @csrf
                        или
                        <button class="link" type="submit">Отклонить</button> оппонента
                    </form>
                @else
                    <form method="POST" action="{{ route('battles.destroy', $battle) }}">
                        @csrf
                        @method('DELETE')
                        <button class="button" type="submit">Отменить заявку</button>
                        или дождитесь соперника
                    </form>
                @endif
            @elseif ($isOpponent)
                <form method="POST" action="{{ route('battles.cancel', $battle) }}">
                    @csrf
                    <button class="button" type="submit">Отозвать заявку</button>
                    или дождитесь подтверждения
                </form>
            @elseif ($canJoin)
                <form method="POST" action="{{ route('battles.apply', $battle) }}">
                    @csrf
                    <button class="button" type="submit">Принять</button>
                </form>
            @endif
        </div>
    @endif
</div>
