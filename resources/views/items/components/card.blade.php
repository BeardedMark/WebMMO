<form action="{{ route('items.move') }}" method="POST">
    @csrf
    <input type="hidden" name="item_id" value="{{ $item->item->id }}">
    <input type="hidden" name="from_container_type" value="{{ $fromContainer }}">
    <input type="hidden" name="from_container_id" value="{{ $fromId }}">
    <input type="hidden" name="to_container_type" value="{{ $toContainer }}">
    <input type="hidden" name="to_container_id" value="{{ $toId }}">
    <input type="hidden" name="stack" value="{{ $item->stack }}">

    <button class="button relative" type="submit" data-tooltip="Переместить">
        <img width="32" src="{{ $item->item->getImageUrl() }}" alt="">
        <small class="color-brand absolute text-end fill" style="top: 0; left: 0; z-index; 1">{{ $item->stack }}</small>
    </button>
</form>
