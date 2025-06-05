<?php

namespace App\Domains\Modifiers\Traits;

use App\Domains\Modifiers\Services\ModifierService;
use Illuminate\Support\Collection;

trait HasModifiers
{
    /**
     * Получить "сырые" модификаторы (массив или коллекция).
     */
    public function getRawModifiers(): array
    {
        return is_array($this->modifiers)
            ? $this->modifiers
            : (is_iterable($this->modifiers) ? collect($this->modifiers)->toArray() : []);
    }

    /**
     * Получить модификаторы как экземпляры ModifierInstance.
     */
    public function getModifierInstances(): Collection
    {
        return ModifierService::getModifierInstances($this->getRawModifiers());
    }

    /**
     * Установить модификаторы (массив формата данных).
     */
    public function setModifiers(array $modifiers): void
    {
        $this->modifiers = $modifiers;
        $this->save();
    }

    /**
     * Есть ли хотя бы один модификатор?
     */
    public function hasModifiers(): bool
    {
        return $this->getModifierInstances()->isNotEmpty();
    }

    /**
     * Получить суммированные модификаторы (по коду).
     */
    public function getSummedModifiers(): Collection
    {
        return ModifierService::sumModifiers($this->getRawModifiers());
    }
}
