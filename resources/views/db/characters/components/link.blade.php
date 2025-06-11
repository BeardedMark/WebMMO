<a class="link {{ auth()->user()->currentCharacter()->id == $character->id ? 'font-light-brand' : ''}}" href="{{ route('characters.show', $character) }}" data-tooltip="{{ $character->description }}">
    {{ $character->getTitle() }}
</a>
