<?php

namespace App\Services\Instances;

use App\Models\Entity;
use Illuminate\Support\Collection;

class EntityInstance extends BaseInstance
{
    public function getModel()
    {
        // return Entity::find($this->getData()->id);
    }
}
