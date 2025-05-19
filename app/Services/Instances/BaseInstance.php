<?php

namespace App\Services\Instances;

use App\Models\Item;
use Illuminate\Support\Collection;

class BaseInstance
{
    public function __construct(
        public $data
    ) {}

    public function getData(): object
    {
        return (object)$this->data;
    }

    // Values

    public function getUuid(): string
    {
        return $this->getData()->uuid;
    }

    public function getStack(): int
    {
        return $this->getData()->stack;
    }

    public function getModifiers()
    {
        return $this->getData()->modifiers;
    }

    public function haveModifiers(): bool
    {
        return $this->getModifiers() > 0;
    }

    public function getProperties()
    {
        return $this->getData()->properties;
    }

    public function haveProperties(): bool
    {
        return $this->getProperties() > 0;
    }
}
