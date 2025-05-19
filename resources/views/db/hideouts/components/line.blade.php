<p class="flex-row-8">
    @component('hideouts.components.link', compact('hideout'))
    @endcomponent

    {{-- <span class="color-second">#{{ $location->id }}</span> --}}

    <span class="flex grow"></span>
    <small class="color-second">{{ $hideout->getTotalItemsWeight() }} кг</small>
    <small>{{ $hideout->getTotalItemsCount() }} предм</small>
    <small class="color-brand">1 ур</small>
</p>
