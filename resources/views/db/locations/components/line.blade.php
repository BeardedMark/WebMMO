<div class="flex-row-8 ai-center">
    @component('db.locations.components.link', compact('location'))
    @endcomponent

    <p class="flex-grow color-second font-sm">
        <span data-tooltip="Размер локации, влияет на колличество контента на локации">{{ $location->getSize() }} разм.</span>
    </p>

    <p class="font-sm {{ $location->isPeaceful() ? 'color-success' : 'color-danger' }}" data-tooltip="Тут на вас никто не нападет">
        {{ $location->isPeaceful() ? 'Мирно' : 'Враждебно' }}
    </p>

    <p class="color-brand font-sm" data-tooltip="Уровень локации, влияет на сложность и ценность контента">
        {{ $location->getLevel() }} ур
    </p>
</div>
