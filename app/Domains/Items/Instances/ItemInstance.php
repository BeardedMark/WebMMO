<?php

namespace App\Domains\Items\Instances;
use App\Instances\Instance;

use App\Domains\Modifiers\Traits\HasModifiers;
use App\Domains\Modifiers\Traits\HasModifierStats;

use App\Domains\Items\Models\Item;

class ItemInstance extends Instance
{
    use HasModifiers;
    use HasModifierStats;

    public int $stack;
    public array $modifiers;

    public function __construct(array $data) {
        $this->data = $data;
        $this->uuid = $data['uuid'];
        $this->code = $data['code'];
        $this->stack = $data['stack'];
        $this->modifiers = $data['modifiers'];
    }

    public function getModel()
    {
        return Item::where('code', $this->getCode())->first();
    }

    public function getWeight(): float
    {
        return ($this->getModel()->getWeight() ?? 0) * $this->getStack();
    }

    public function isDisassemble(): bool
    {
        return count($this->getModel()->getCraftItems()) > 0;
    }

    public function isEquipment(): bool
    {
        return isset($this->getModel()->slot);
    }

    public function getSlot(): string
    {
        return $this->getModel()->slot;
    }

    public function getStack(): string
    {
        return $this->stack;
    }
    public function increaseStack($amount): void
    {
        $this->stack = max(0, ($this->stack ?? 0) + $amount);
    }

    public function decreaseStack(int $amount = 1): void
    {
        $this->stack = max(0, ($this->stack ?? 0) - $amount);
    }
}
