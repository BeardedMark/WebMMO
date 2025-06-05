<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domains\Locations\Models\Location;

class Road extends Model
{
    use SoftDeletes;

    protected $fillable = [];

    public function fromLocation()
    {
        return $this->belongsTo(Location::class, 'from_location_code', 'code');
    }

    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to_location_code', 'code');
    }

    public function getDistance(): float
    {
        $from = $this->fromLocation;
        $to = $this->toLocation;

        if (!$from || !$to) return 0;

        $distance = sqrt(pow($to->x - $from->x, 2) + pow($to->y - $from->y, 2));

        return ceil($distance / 50);
    }

    public static function betweenRoad(Location $from, Location $to): ?Road
    {
        return self::query()
            ->where(function ($q) use ($from, $to) {
                $q->where('from_location_code', $from->code)
                  ->where('to_location_code', $to->code);
            })
            ->orWhere(function ($q) use ($from, $to) {
                $q->where('from_location_code', $to->code)
                  ->where('to_location_code', $from->code);
            })
            ->first();
    }
}

