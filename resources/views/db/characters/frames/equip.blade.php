<div class="frame">
    <div class="row g-0">
        <div class="col col-3">
            <div class="img-frame" style="height: 100px">
                @if ($character->isClassEquipped('backpack'))
                    <img class="rarity-{{ count($character->getEquippedByClass('backpack')->getModifiers()) }}" src="{{ $character->getEquippedByClass('backpack')->getModel()->getImageUrl() }}"
                        alt="">
                @endif
            </div>

            <div class="img-frame" style="height: 200px">
                @if ($character->isClassEquipped('weapon'))
                    <img class="rarity-{{ count($character->getEquippedByClass('weapon')->getmodifiers()) }}" height="100%"
                        src="{{ $character->getEquippedByClass('weapon')->getmodel()->getImageUrl() }}" alt="">
                @endif
            </div>

            <div class="img-frame" style="height: 100px">
                @if ($character->isClassEquipped('legs'))
                    <img class="rarity-{{ count($character->getEquippedByClass('legs')->getmodifiers()) }}" src="{{ $character->getEquippedByClass('legs')->getmodel()->getImageUrl() }}" alt="">
                @endif
            </div>

            <div class="img-frame" style="height: 100px">
                @if ($character->isClassEquipped('feet'))
                    <img class="rarity-{{ count($character->getEquippedByClass('feet')->getmodifiers()) }}" src="{{ $character->getEquippedByClass('feet')->getmodel()->getImageUrl() }}" alt="">
                @endif
            </div>
        </div>

        <div class="col col-6">
            <div class="img-frame" style="height: 100px">
                @if ($character->isClassEquipped('head'))
                    <img class="rarity-{{ count($character->getEquippedByClass('head')->getmodifiers()) }}" src="{{ $character->getEquippedByClass('head')->getmodel()->getImageUrl() }}" alt="">
                @endif
            </div>

            <div class="img-frame" style="height: 200px">
                @if ($character->isClassEquipped('armor'))
                    <img class="rarity-{{ count($character->getEquippedByClass('armor')->getmodifiers()) }}" src="{{ $character->getEquippedByClass('armor')->getmodel()->getImageUrl() }}" alt="">
                @endif
            </div>

            <div class="img-frame" style="height: 200px">
                @if ($character->isClassEquipped('belt'))
                    <img class="rarity-{{ count($character->getEquippedByClass('belt')->getmodifiers()) }}" src="{{ $character->getEquippedByClass('belt')->getmodel()->getImageUrl() }}" alt="">
                @endif
            </div>
        </div>

        <div class="col col-3">
            <div class="img-frame" style="height: 100px">
                @if ($character->isClassEquipped('face'))
                    <img class="rarity-{{ count($character->getEquippedByClass('face')->getmodifiers()) }}"
                        src="{{ $character->getEquippedByClass('face')->getmodel()->getImageUrl() }}" alt="">
                @endif
            </div>

            <div class="img-frame" style="height: 200px">
                @if ($character->isClassEquipped('meele'))
                    <img class="rarity-{{ count($character->getEquippedByClass('meele')->getmodifiers()) }}" src="{{ $character->getEquippedByClass('meele')->getmodel()->getImageUrl() }}" alt="">
                @endif
            </div>

            <div class="img-frame" style="height: 100px">
                @if ($character->isClassEquipped('body'))
                    <img class="rarity-{{ count($character->getEquippedByClass('body')->getmodifiers()) }}" src="{{ $character->getEquippedByClass('body')->getmodel()->getImageUrl() }}" alt="">
                @endif
            </div>

            <div class="img-frame" style="height: 100px">
                @if ($character->isClassEquipped('hands'))
                    <img class="rarity-{{ count($character->getEquippedByClass('hands')->getmodifiers()) }}" src="{{ $character->getEquippedByClass('hands')->getmodel()->getImageUrl() }}" alt="">
                @endif
            </div>
        </div>
    </div>
</div>
