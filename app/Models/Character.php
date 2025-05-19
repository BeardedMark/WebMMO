<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasItems;
use App\Traits\HasEquipment;
use Illuminate\Database\Eloquent\SoftDeletes;


class Character extends Model
{
    use SoftDeletes;
    use HasItems, HasEquipment;

    protected $fillable = [
        'name',
        'user_id',
        'status',
        'equipment',
        'regenerated_at',
        'experience',
        'regenerated_at',
        'logs'
    ];

    protected $casts = [
        'equipment' => 'array',
        'items' => 'array',
        'logs' => 'array',
    ];

    // Values

    public function getTitle()
    {
        return $this->name;
    }

    public function getStatus()
    {
        return $this->status ?? ($this->timeToNextAction() > 0 ? 'В пути' : 'Отдыхает');
    }

    public function getLogs(): array
    {
        return is_array($this->logs) ? $this->logs : [];
    }

    public function addLog(string $type, string $message): void
    {
        $logs = $this->getLogs();

        $logs[] = [
            'datetime' => now()->toDateTimeString(),
            'type' => $type,
            'message' => $message,
        ];

        if (count($logs) > 8) {
            $logs = array_slice($logs, -8);
        }

        $this->logs = $logs;
        $this->save();
    }

    public function getViewRange()
    {
        return 100 + $this->getEquipmentStat('vision_range');
    }

    public function health()
    {
        return 10 + $this->getEquipmentStat('increase_health') + $this->strength();
    }

    public function getRegen()
    {
        return 1 + $this->getEquipmentStat('life_regen');
    }

    public function setRegenerationTime(int $currentHealth): void
    {
        $maxHealth = $this->health(); // например, 100
        $regenPerSecond = $this->getRegen(); // например, 1 HP/sec

        $missingHealth = max(0, $maxHealth - $currentHealth);

        if ($regenPerSecond > 0 && $missingHealth > 0) {
            $secondsToFull = ceil($missingHealth / $regenPerSecond);
            $this->regenerated_at = now()->addSeconds($secondsToFull);
        } else {
            $this->regenerated_at = now();
        }

        $this->save();
    }

    public function getCurrentHealth(): int
    {
        $maxHealth = $this->health();
        $regenPerSecond = $this->getRegen();
        $regeneratedAt = $this->regenerated_at ?? now();

        // Если регенерация отключена или уже полностью восстановился
        if ($regenPerSecond === 0 || now()->gte($regeneratedAt)) {
            return $maxHealth;
        }

        // Сколько секунд осталось до полного восстановления
        $secondsRemaining = now()->diffInSeconds($regeneratedAt, false);

        // Сколько здоровья ещё не восстановлено
        $missingHealth = $secondsRemaining * $regenPerSecond;

        // Текущее здоровье = максимум - то, что ещё не восстановлено
        $currentHealth = max(0, $maxHealth - $missingHealth);

        return (int) $currentHealth;
    }


    public function getHealthPercent(): int
    {
        $currentHealth = $this->getCurrentHealth();
        $maxHealth = $this->health();

        if ($maxHealth === 0) {
            return 0;
        }

        return floor(($currentHealth / $maxHealth) * 100);
    }


    public function endurance()
    {
        return 10 + $this->agility();
    }
    public function damage()
    {
        $damage = 1;
        $stats = [
            "physical_damage",
            "slashing_damage",
            "piercing_damage",
            "blunt_damage"
        ];

        foreach ($stats as $stat) {
            $damage += $this->getEquipmentStat($stat);
        }

        return $damage + $this->getLevel() + $this->strength();
    }
    public function defense()
    {
        $defense = 0;
        $stats = [
            "physical_resistance",
            "slashing_resistance",
            "piercing_resistance",
            "blunt_resistance"
        ];

        foreach ($stats as $stat) {
            $defense += $this->getEquipmentStat($stat);
        }

        return $defense;
    }
    public function strength()
    {
        return 0 + $this->getEquipmentStat('increase_strength');
    }
    public function agility()
    {
        return 990 + $this->getEquipmentStat('increase_agility');
    }
    public function intelligence()
    {
        return 0 + $this->getEquipmentStat('increase_intelligence');
    }
    public function maxWeight()
    {
        return 100 + $this->strength() + $this->getEquipmentStat('weight_carry');
    }
    public function overWeight()
    {
        $overWeight = $this->getTotalWeight() - $this->maxWeight();
        return $overWeight > 0 ? $overWeight : 0;
    }
    public function moveSpeed()
    {
        return ($this->agility() + $this->getEquipmentStat('move_speed')) / 10;
    }
    public function dropChance()
    {
        return $this->intelligence() / 10;
    }

    public function getExpiriance()
    {
        return $this->experience;
    }

    public function getLevel()
    {
        $level = 0;
        $expToNext = 10;
        $growthRate = 2.5;
        $experience = $this->getExpiriance();

        while ($experience >= $expToNext) {
            $experience -= $expToNext;
            $level++;
            $expToNext = intval($expToNext * $growthRate);
        }

        return $level;
    }

    public function getLevelPercent()
    {
        $level = $this->getLevel();
        $exp = $this->getExpiriance();

        $expToCurrentLevel = $this->getTotalExpToLevel($level);
        $expToNextLevel = $this->getTotalExpToLevel($level + 1);

        $currentExp = $exp - $expToCurrentLevel;
        $levelExp = $expToNextLevel - $expToCurrentLevel;

        return $levelExp > 0 ? floor(($currentExp / $levelExp) * 100) : 100;
    }


    public function experienceToCurrentLevel()
    {
        $level = $this->getLevel();
        return $this->getTotalExpToLevel($level);
    }

    public function experienceToNextLevel()
    {
        $level = $this->getLevel();
        return $this->getTotalExpToLevel($level + 1);
    }


    public function getTotalExpToLevel($level)
    {
        $exp = 0;
        $expToNext = 10;
        $growthRate = 2.5;

        for ($i = 0; $i < $level; $i++) {
            $exp += $expToNext;
            $expToNext = intval($expToNext * $growthRate);
        }

        return $exp;
    }


    public function increaseExperience(int $experience): void
    {
        $this->increment('experience', $experience);
    }

    public function reduceExperience(int $experience): void
    {
        $result = $this->getExpiriance() - $experience;

        if ($result < $this->experienceToCurrentLevel()) {
            $this->experience = $this->experienceToCurrentLevel();
            $this->save();
        } else {
            $this->decrement('experience', $experience);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Transitions

    public function allTransitions()
    {
        return $this->hasMany(Transition::class);
    }

    public function latestTransitions($limit = 10)
    {
        return $this->hasMany(Transition::class)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    public function latestTransition()
    {
        return $this->hasOne(Transition::class)->latestOfMany();
    }

    public function transition()
    {
        return $this->hasOne(Transition::class)->latestOfMany();
    }

    public function timeToNextAction()
    {
        // $transition = $this->latestTransition()->first();

        // if (!$transition || !$transition->next_action_at) {
        //     return 0;
        // }

        return max(0, now()->diffInSeconds($this->next_action_at, false));
    }

    public function setDelayToNextAction($seconds): void
    {
        $validSeconds = $seconds - ($seconds * $this->moveSpeed() / 100);
        $this->next_action_at = now()->addSeconds($validSeconds);
        $this->save();
    }

    public function timeOnCurrentLocation()
    {
        $transition = $this->latestTransition()->first();

        if (!$transition || !$transition->created_at) {
            return null;
        }

        return $transition->created_at->diffInSeconds(now());
    }

    // Locations

    public function currentLocation()
    {
        $latestTransition = $this->latestTransition;
        return $latestTransition?->location;
    }

    public function location()
    {
        return $this->transition->location();
    }

    public function availableLocations()
    {
        $currentLocation = $this->currentLocation();

        if ($currentLocation) {
            return $currentLocation->connectedLocations();
        } else {
            return Location::where('level', 0)->where('is_open', true)->get();
        }
    }

    public function visitedLocations()
    {
        return $this->hasMany(Transition::class)
            ->with('location')
            ->get()
            ->pluck('location')
            ->unique('id');
    }

    public function unvisitedLocations()
    {
        $visited = $this->visitedLocations()->pluck('id');

        $connected = Location::whereIn('id', function ($query) use ($visited) {
            $query->select('to_location_id')
                ->from('roads')
                ->whereIn('from_location_id', $visited)
                ->where('is_open', true)
                ->union(
                    Road::select('from_location_id')
                        ->whereIn('to_location_id', $visited)
                        ->where('is_open', true)
                        ->where('is_one_way', false)
                );
        })
            ->whereNotIn('id', $visited)
            ->get();

        return $connected;
    }

    // Roads
    public function roadsToUnvisitedLocations()
    {
        $visitedLocations = $this->visitedLocations()->pluck('id');
        $unvisitedLocations = Location::whereNotIn('id', $visitedLocations)->pluck('id');

        return Road::whereIn('from_location_id', $visitedLocations)
            ->whereIn('to_location_id', $unvisitedLocations)
            ->orWhereIn('from_location_id', $unvisitedLocations)
            ->whereIn('to_location_id', $visitedLocations)
            ->get();
    }

    public function roadsToVisitedLocations()
    {
        $visitedLocations = $this->visitedLocations()->pluck('id');

        return Road::whereIn('from_location_id', $visitedLocations)
            ->whereIn('to_location_id', $visitedLocations)
            ->get();
    }

    public function availableRoads()
    {
        $current = $this->currentLocation();

        return Road::where(function ($query) use ($current) {
            $query->where('from_location_id', $current->id)
                ->orWhere('to_location_id', $current->id);
        })->get();
    }
}
