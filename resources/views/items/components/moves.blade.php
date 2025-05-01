<form class="row g-1" action="{{ route('items.moves') }}" method="POST" class="flex items-center gap-2">
    @csrf
    <input type="hidden" name="from_container_type" value="{{ $fromContainer }}">
    <input type="hidden" name="from_container_id" value="{{ $fromId }}">
    <input type="hidden" name="to_container_type" value="{{ $toContainer }}">
    <input type="hidden" name="to_container_id" value="{{ $toId }}">

    <div class="col-auto">
        <button class="icon" type="submit" data-tooltip="Переместить все">
            @component('elements.icon', ['size' => 21, 'name' => 'up-right-arrow', 'color' => 'BAC7E3'])
            @endcomponent
        </button>
    </div>
</form>
