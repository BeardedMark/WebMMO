<?php

namespace App\Instances;

class Instance
{
    public array $data;
    public string $uuid;
    public string $code;

    public function getData(): array
    {
        return $this->data;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
