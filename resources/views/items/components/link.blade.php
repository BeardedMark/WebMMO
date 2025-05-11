
<a class="link" href="{{ route('items.show', $item) }}">
    <img width="21" src="{{ $item->getImageUrl() }}" alt="">
    {{ $item->getTitle() }}
</a>
