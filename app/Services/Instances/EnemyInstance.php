<?php

namespace App\Services\Instances;

use App\Models\Enemy;
use Illuminate\Support\Collection;

class ItemInstance extends BaseInstance
{
    public function getModel()
    {
        return Enemy::find($this->getData()->id);
    }
}
