<?php

namespace App\Domains\Modifiers\Instances;

use App\Instances\Instance;
use App\Domains\Modifiers\Models\Modifier;

class ModifierInstance extends Instance
{
    public float $value;
    public int $level;
    public array $modifiers;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->uuid = $data['uuid'] ?? null;
        $this->code = $data['code'] ?? '';
        $this->value = (float) ($data['value'] ?? 0);
        $this->level = $data['level'] ?? 1;
        $this->modifiers = $data['modifiers'] ?? [];
    }

    /**
     * Получить связанную модель-шаблон модификатора (Modifier)
     */
    public function getModel(): ?Modifier
    {
        return Modifier::where('code', $this->getCode())->first();
    }

    /**
     * Получить имя модификатора из модели
     */
    public function getName()
    {
        return $this->getModel()?->name ?? '???';
    }

    /**
     * Получить значение в виде текста с учетом знака и %
     */
    public function getValueTitle()
    {
        $isPercent = $this->getModel()?->is_percent ?? false;
        return ($this->value > 0 ? '+' : '') . $this->value . ($isPercent ? '%' : '');
    }

    /**
     * Получить числовое значение модификатора
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * Установить новое значение модификатора
     */
    public function setValue(float $value)
    {
        return $this->value = $value;
    }
}
