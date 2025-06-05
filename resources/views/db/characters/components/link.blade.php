<a class="link " href="{{ route('characters.show', $character) }}">
    {{ $character->getTitle() }}
</a>
{{-- {{ auth()->user()->currentCharacter()->id == $character->id ? 'font-light-brand' : ''}} --}}
