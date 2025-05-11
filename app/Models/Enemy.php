<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Enemy extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'image', 'spawn_chance', 'danger', 'min_level', 'max_level'
    ];

    protected $casts = [
        'drop' => 'array'
    ];

    public function getTitle()
    {
        return $this->name;
    }

    public function getDanger()
    {
        return $this->danger;
    }

    public function getSpawnChance()
    {
        return $this->spawn_chance;
    }

    public function getMinLevel()
    {
        return $this->min_level;
    }

    public function getMaxLevel()
    {
        return $this->max_level;
    }

    public function getImageUrl()
    {
        return asset('storage/img/enemies/' . $this->image);
    }

    public function health()
    {
        return 10 * ($this->danger == 0 ? 1 : $this->danger);
    }

    public function danger()
    {
        return $this->danger;
    }

    public function damage()
    {
        return 1;// * ($this->danger == 0 ? 1 : $this->danger);
    }

    public function availableItems()
    {
        $itemsData = collect($this->drop);
        return Item::whereIn('id', $itemsData)->orderBy('drop_chance')->get();
    }

    public function availableLocations()
    {
        $query = Location::query();

        if (!is_null($this->min_level)) {
            $query->where('level', '>=', $this->min_level);
        }

        if (!is_null($this->max_level)) {
            $query->where('level', '<=', $this->max_level);
        }

        return $query->orderBy('level')->get();
    }

    public static function generateEnemies($totalCount, $availableEnemies, $chanceScale = 0): array
    {
        $enemies = [];
        $maxEnemies = mt_rand(1, $totalCount);
        $totalAdded = 0;

            foreach ($availableEnemies as $enemy) {
                $stack = 0;

                for ($i = 0; $i <= ($maxEnemies - $totalAdded); $i++) {
                    if (mt_rand(1, 100) <= $enemy->spawn_chance + $enemy->spawn_chance * ($chanceScale / 100)) {
                        $stack++;
                        $totalAdded++;

                        if ($totalAdded >= $maxEnemies) {
                            break 2;
                        }
                    }
                }

                if ($stack > 0) {
                    $enemies[] = [
                        'id' => $enemy->id,
                        'stack' => $stack,
                    ];
                }
            }

        return $enemies;
    }
}
