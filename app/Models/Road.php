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

        return ceil($distance / 50) * 100;
    }

    public function getTimeToDistanceFormatted(int $moveSpeed): string
    {
        // целочисленное количество секунд
        $distance = (int) $this->getDistance();
        $seconds = $distance / ($moveSpeed / 3.6);

        $hours   = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);
        $secs    = $seconds % 60;

        $parts = [];
        if ($hours   > 0) $parts[] = $hours   . 'ч';
        if ($minutes > 0) $parts[] = $minutes . 'м';
        if ($secs    > 0) $parts[] = $secs    . 'с';

        // если всё же получилось 0, возвращаем "0с"
        return $parts
            ? implode(' ', $parts)
            : '0с';
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
