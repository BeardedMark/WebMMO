<p class="flex-row-8 ai-center">
    @component('db.locations.components.link', compact('location'))
    @endcomponent

    <span class="flex grow color-second font-sm">
        {{ $location->getSize() }} разм.
    </span>

    <span class="font-sm {{ $location->isPeaceful() ? 'color-success' : 'color-danger' }}">
        {{ $location->isPeaceful() ? 'Мирно' : 'Враждебно' }}
    </span>

    <span class="color-brand font-sm">
        {{ $location->getLevel() }} ур
    </span>
</p>
