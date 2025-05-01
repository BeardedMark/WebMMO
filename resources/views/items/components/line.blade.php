<p class="flex-row-8">
    <a class="link" href="{{ route('items.show', $item) }}">
        <img width="21" src="{{ $item->getImageUrl() }}" alt="">
        {{ $item->getTitle() }}
    </a>
    {{-- <span class="flex grow"></span> --}}
    {{-- <small >{{ $item->getWeight() }}</small> --}}
</p>
