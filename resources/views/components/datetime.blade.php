@component('components.stat', [
    'name' => 'Дата создания',
    'value' => $entity->created_at,
])
@endcomponent

@if ($entity->created_at != $entity->updated_at)
    @component('components.stat', [
        'name' => 'Дата изменения',
        'value' => $entity->updated_at,
    ])
    @endcomponent
@endif

@isset($character->deleted_at)
    @component('components.stat', [
        'name' => 'Дата удаления',
        'value' => $entity->deleted_at,
    ])
    @endcomponent
@endisset
