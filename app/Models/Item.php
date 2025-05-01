<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'image', 'weight', 'drop_chance', 'min_level', 'max_level'
    ];

    // Values

    public function getTitle()
    {
        return "{$this->name}";
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getDropChance()
    {
        return $this->drop_chance;
    }

    public function getWeightTitle()
    {
        return "{$this->weight} кг";
    }

    public function getImageUrl()
    {
        return asset('storage/img/items/' . $this->image);
    }
}
