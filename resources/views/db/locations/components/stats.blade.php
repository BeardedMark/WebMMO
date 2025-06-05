

    <div class="flex-row-13">
        <p class="flex-col ai-center font-center w-100">
            <span>{{ $location->getSize() }}</span>
            <span class="color-second font-sm">Разм</span>
        </p>
        <p class="flex-col ai-center font-center w-100">
            <span>{{ count($location->availableItems()) }}</span>
            <span class="color-second font-sm">Предм</span>
        </p>
        <p class="flex-col ai-center font-center w-100">
            <span>{{ count($location->availableEnemies()) }}</span>
            <span class="color-second font-sm">Врагов</span>
        </p>
    </div>
