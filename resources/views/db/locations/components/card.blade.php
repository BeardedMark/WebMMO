<div id="location-{{ $location->getId() }}" class="frame flex-col-13">
    @component('db.locations.components.line', compact('location'))
    @endcomponent

    @if ($location->getImageUrl())
        <div class="img-contain">
            <img src="{{ $location->getImageUrl() }}" alt="{{ $location->getTitle() }}">
        </div>
    @endif

    {{-- <div class="flex-row-8">
        @component('components.stamp', [
            'header' => $location->getSize(),
            'note' => 'Разм',
            'tooltip' => 'Разамер локации',
        ])
        @endcomponent

        @component('components.stamp', [
            'header' => count($location->availableItems()),
            'note' => 'Предм',
            'tooltip' => 'Предметов локации',
        ])
        @endcomponent

        @component('components.stamp', [
            'header' => count($location->availableEnemies()),
            'note' => 'Врагов',
            'tooltip' => 'Врагов локации',
        ])
        @endcomponent
    </div> --}}
</div>
