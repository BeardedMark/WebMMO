<?php

namespace App\Services\Instances;

use App\Models\Item;
use Illuminate\Support\Collection;

class ItemInstance extends BaseInstance
{
    public function getModel()
    {
        return Item::find($this->getData()->id);
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
        return isset($this->getModel()->class);
    }
}
