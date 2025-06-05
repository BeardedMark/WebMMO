<div class="">
    <div class="row g-0 ai-center">
        <div class="col col-auto">
            <div class="flex-col-13 pad-13">
                <div class="item-frame">
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

                <div class="item-frame">
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

                <div class="item-frame">
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

                <div class="item-frame">
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

                <div class="item-frame">
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
        </div>

        <div class="col">
            <div class="img-contain">
                <img width="100%" height="100%" src="{{ $character->getImageUrl() }}"
                    alt="">
            </div>
        </div>

        <div class="col col-auto">
            <div class="flex-col-13 pad-13">
                <div class="item-frame">
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

                <div class="item-frame">
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

                <div class="item-frame">
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

                <div class="item-frame">
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

                <div class="item-frame">
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

                <div class="item-frame">
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
    </div>
</div>
