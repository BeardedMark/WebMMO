<?php

namespace App\Domains\Containers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'name', 'description', 'image', 'spawn_chance',
        'modifiers', 'properties', 'requirements', 'drop',
    ];

    protected $casts = [
        'modifiers' => 'array',
        'properties' => 'array',
        'requirements' => 'array',
        'drop' => 'array',
    ];

    public function getTitle(): string
    {
        return $this->name ?? $this->code;
    }

    public function getImageUrl(): string
    {
        return asset('storage/images/objects/' . $this->image);
    }
    public function getRequirements(): array
    {
        return $this->requirements ?? [];
    }

    public function getItems(): array
    {
        return $this->items ?? [];
    }
}
