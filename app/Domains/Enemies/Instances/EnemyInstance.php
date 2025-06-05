<?php

namespace App\Domains\Enemies\Instances;
use App\Instances\Instance;

use App\Domains\Enemies\Models\Enemy;
use App\Domains\Modifiers\Traits\HasModifierStats;
use App\Domains\Modifiers\Traits\HasEquipment;
use App\Domains\Modifiers\Traits\HasModifiers;
use App\Domains\Modifiers\Services\ModifierService;

class EnemyInstance extends Instance
{
    use HasModifierStats;
    use HasEquipment;
    use HasModifiers;

    public int $level;
    public int $stack;
    public array $modifiers;

    public function __construct(array $data) {
        $this->data = $data;
        $this->uuid = $data['uuid'];
        $this->code = $data['code'];
        $this->stack = $data['stack'];

        $this->level = $data['level'];
        $this->modifiers = $data['modifiers'];
    }

    public function getModel()
    {
        return Enemy::where('code', $this->getCode())->first();
    }
    public function getRequirements()
    {
        return $this->getModel()->getRequirements();
    }
    public function getItems()
    {
        return $this->getModel()->getItems();
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getStack()
    {
        return $this->stack;
    }

    public function getModifierStats()
    {
        $modifiers = $this->getModifierInstances();
        $modifiers = $modifiers->merge($this->getEquipmentModifiers());

        return ModifierService::sumModifiers($modifiers);
    }
}
