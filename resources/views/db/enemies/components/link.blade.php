<p class="flex-row-8">
    <a class="link" href="{{ route('enemies.show', $enemy) }}">
        <img width="21" src="{{ $enemy->getImageUrl() }}" alt="" style="border-radius: 100%">
        {{ $enemy->getTitle()}}
    </a>
</p>
