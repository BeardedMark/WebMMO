@php
    $self = auth()->user()->currentCharacter();
    $isFinished = !is_null($battle->winner_id);
    $isCreator = $self->id === $battle->creator_id;
    $isOpponent = $self->id === $battle->opponent_id;
    $hasOpponent = !is_null($battle->opponent_id);
    $isParticipant = $isCreator || $isOpponent;
    $canJoin = !$isParticipant && !$hasOpponent && !$self->inBattle();
@endphp

<div class="flex-row-8">
    <p class="flex-row-5 ai-center color-second">
        <a class="link" href="{{ route('battles.show', $battle) }}">{{ $battle->getTitle() }} бой</a>

        <span
            class="flex color-{{ $battle->hasWinner() ? 'second' : ($battle->hasOpponent() ? 'warning' : 'success') }} font-sm text-end">
            {{ $battle->getStatus() }}
        </span>

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
            ожидает соперника
        @endif
    </p>

    <span class="flex-grow"></span>

    @if (!$isFinished)
        <div class="flex-row-5 ai-center color-second font-sm">
            @if ($isCreator)
                @if ($hasOpponent)
                    <form method="POST" action="{{ route('battles.confirm', $battle) }}">
                        @csrf
                        <button class="link" type="submit">Начать бой</button>
                    </form>

                    или

                    <form method="POST" action="{{ route('battles.reject', $battle) }}">
                        @csrf
                        <button class="link" type="submit">Отклонить оппонента</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('battles.destroy', $battle) }}">
                        @csrf
                        @method('DELETE')
                        <button class="link" type="submit">Отменить бой</button>
                    </form>
                @endif
            @elseif ($isOpponent)
                <form method="POST" action="{{ route('battles.cancel', $battle) }}">
                    @csrf
                    <button class="link" type="submit">Отозвать заявку</button>
                </form>
            @elseif ($canJoin)
                <form method="POST" action="{{ route('battles.apply', $battle) }}">
                    @csrf
                    <button class="link" type="submit">Принять заявку</button>
                </form>
            @endif
        </div>
    @endif
</div>
