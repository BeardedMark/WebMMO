<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Road extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'from_location_id', 'to_location_id', 'is_one_way', 'is_open', 'size'
    ];

    public function fromLocation()
    {
        return $this->belongsTo(Location::class, 'from_location_id');
    }

    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to_location_id');
    }

    public function getDistance()
    {
        $fromLocation = $this->fromLocation;
        $toLocation = $this->toLocation;

        if (!$fromLocation || !$toLocation) {
            return 0; // Если одна из локаций отсутствует, возвращаем 0
        }

        // Получаем координаты локаций
        $x1 = $fromLocation->x;
        $y1 = $fromLocation->y;
        $x2 = $toLocation->x;
        $y2 = $toLocation->y;

        $result = sqrt(pow($x2 - $x1, 2) + pow($y2 - $y1, 2));
        $result = ceil($result / 50);

        return $result;
    }

    public function getCenterCoordinates()
    {
        $fromLocation = $this->fromLocation;
        $toLocation = $this->toLocation;

        if (!$fromLocation || !$toLocation) {
            return null; // Если одна из локаций отсутствует, возвращаем null
        }

        // Получаем координаты локаций
        $x1 = $fromLocation->x;
        $y1 = $fromLocation->y;
        $x2 = $toLocation->x;
        $y2 = $toLocation->y;

        // Находим центр дороги (среднее значение координат)
        $centerX = ($x1 + $x2) / 2;
        $centerY = ($y1 + $y2) / 2;

        return ['x' => $centerX, 'y' => $centerY];
    }

}
