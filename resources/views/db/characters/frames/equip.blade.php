<div class="flex-row-8 ai-center pad-13">
    <div class="flex-col-8">
        <div class="item-frame" data-tooltip="Голова">
            @if ($character->isSlotEquipped('head'))
                @component('db.items.components.card', [
                    'item' => $character->getEquippedBySlot('head'),
                    'fromContainer' => $character->getTable(),
                    'fromId' => $character->id,
                    'toContainer' => $character->getTable(),
                    'toId' => $character->id,
                ])
                @endcomponent
            @endif
        </div>

        <div class="item-frame" data-tooltip="Лицо">
            @if ($character->isSlotEquipped('face'))
                @component('db.items.components.card', [
                    'item' => $character->getEquippedBySlot('face'),
                    'fromContainer' => $character->getTable(),
                    'fromId' => $character->id,
                    'toContainer' => $character->getTable(),
                    'toId' => $character->id,
                ])
                @endcomponent
            @endif
        </div>

        <div class="item-frame" data-tooltip="Грудь">
            @if ($character->isSlotEquipped('armor'))
                @component('db.items.components.card', [
                    'item' => $character->getEquippedBySlot('armor'),
                    'fromContainer' => $character->getTable(),
                    'fromId' => $character->id,
                    'toContainer' => $character->getTable(),
                    'toId' => $character->id,
                ])
                @endcomponent
            @endif
        </div>

        <div class="item-frame" data-tooltip="Тело">
            @if ($character->isSlotEquipped('body'))
                @component('db.items.components.card', [
                    'item' => $character->getEquippedBySlot('body'),
                    'fromContainer' => $character->getTable(),
                    'fromId' => $character->id,
                    'toContainer' => $character->getTable(),
                    'toId' => $character->id,
                ])
                @endcomponent
            @endif
        </div>

        <div class="item-frame" data-tooltip="Руки">
            @if ($character->isSlotEquipped('hands'))
                @component('db.items.components.card', [
                    'item' => $character->getEquippedBySlot('hands'),
                    'fromContainer' => $character->getTable(),
                    'fromId' => $character->id,
                    'toContainer' => $character->getTable(),
                    'toId' => $character->id,
                ])
                @endcomponent
            @endif
        </div>
    </div>

    <div class="img-contain" data-tooltip="{{ !empty($character->description) ? $character->description : '...' }}">
        <img width="100%" height="100%" src="{{ $character->getImageUrl() }}" alt="">
    </div>

    <div class="flex-col-8">
        <div class="item-frame" data-tooltip="Спина">
            @if ($character->isSlotEquipped('back'))
                @component('db.items.components.card', [
                    'item' => $character->getEquippedBySlot('back'),
                    'fromContainer' => $character->getTable(),
                    'fromId' => $character->id,
                    'toContainer' => $character->getTable(),
                    'toId' => $character->id,
                ])
                @endcomponent
            @endif
        </div>

        <div class="item-frame" data-tooltip="Оружие дальнего боя">
            @if ($character->isSlotEquipped('range'))
                @component('db.items.components.card', [
                    'item' => $character->getEquippedBySlot('range'),
                    'fromContainer' => $character->getTable(),
                    'fromId' => $character->id,
                    'toContainer' => $character->getTable(),
                    'toId' => $character->id,
                ])
                @endcomponent
            @endif
        </div>

        <div class="item-frame" data-tooltip="Оружие ближнего боя">
            @if ($character->isSlotEquipped('melee'))
                @component('db.items.components.card', [
                    'item' => $character->getEquippedBySlot('melee'),
                    'fromContainer' => $character->getTable(),
                    'fromId' => $character->id,
                    'toContainer' => $character->getTable(),
                    'toId' => $character->id,
                ])
                @endcomponent
            @endif
        </div>

        <div class="item-frame" data-tooltip="Пояс">
            @if ($character->isSlotEquipped('belt'))
                @component('db.items.components.card', [
                    'item' => $character->getEquippedBySlot('belt'),
                    'fromContainer' => $character->getTable(),
                    'fromId' => $character->id,
                    'toContainer' => $character->getTable(),
                    'toId' => $character->id,
                ])
                @endcomponent
            @endif
        </div>

        <div class="item-frame" data-tooltip="Ноги">
            @if ($character->isSlotEquipped('legs'))
                @component('db.items.components.card', [
                    'item' => $character->getEquippedBySlot('legs'),
                    'fromContainer' => $character->getTable(),
                    'fromId' => $character->id,
                    'toContainer' => $character->getTable(),
                    'toId' => $character->id,
                ])
                @endcomponent
            @endif
        </div>

        <div class="item-frame" data-tooltip="Ступни">
            @if ($character->isSlotEquipped('feet'))
                @component('db.items.components.card', [
                    'item' => $character->getEquippedBySlot('feet'),
                    'fromContainer' => $character->getTable(),
                    'fromId' => $character->id,
                    'toContainer' => $character->getTable(),
                    'toId' => $character->id,
                ])
                @endcomponent
            @endif
        </div>
    </div>
</div>
