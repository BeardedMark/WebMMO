@component('components.stat', [
    'name' => 'Дата создания',
    'value' => $container->created_at,
])
@endcomponent

@if ($container->created_at != $container->updated_at)
    @component('components.stat', [
        'name' => 'Дата изменения',
        'value' => $container->updated_at,
    ])
    @endcomponent
@endif

@isset($character->deleted_at)
    @component('components.stat', [
        'name' => 'Дата удаления',
        'value' => $container->deleted_at,
    ])
    @endcomponent
@endisset
