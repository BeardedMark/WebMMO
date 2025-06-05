<?php

namespace App\Services\Instances;

use App\Domains\Containers\Models\Container;
use Illuminate\Support\Collection;

class ContainerInstance extends Instance
{
    public function __construct(
        public $data
    ) {}

    public function getModel()
    {
        return Container::where('code', $this->getCode())->first();
    }
    public function getRequirements()
    {
        return $this->getModel()->getRequirements();
    }
    public function getItems()
    {
        return $this->getModel()->getItems();
    }
}
