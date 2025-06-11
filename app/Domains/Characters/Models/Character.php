<?php

namespace App\Domains\Characters\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Domains\Characters\Traits\HasMovement;
use App\Domains\Characters\Traits\HasExperience;
use App\Domains\Characters\Traits\HasBattle;
use App\Domains\Modifiers\Traits\HasEquipment;

use App\Domains\Items\Traits\HasItems;
use App\Domains\Modifiers\Traits\HasModifierStats;
use App\Traits\HasLogs;

use App\Domains\Modifiers\Services\ModifierService;

use App\Models\User;


class Character extends Model
{
    use SoftDeletes;
    use HasItems, HasEquipment;
    use HasModifierStats;
    use HasMovement;
    use HasLogs;
    use HasExperience;
    use HasBattle;

    protected $fillable = [
        'code',
        'name',
        'description',
        'content',
        'image',
        'user_id',
        'equipment',
        'regenerated_at',
        'experience',
        'logs',
        'is_current'
    ];

    protected $casts = [
        'inventory' => 'array',
        'equipment' => 'array',
        'logs' => 'array',
    ];

    // Values

    public function getTitle()
    {
        return $this->name;
    }
    public function getImageUrl()
    {
        return asset('storage/images/characters/avatars/' . $this->image);
    }

    public function getJson(): ?string
    {
        return htmlspecialchars_decode(json_encode($this, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function isOnline(): bool
    {
        $diffInSeconds = abs(now()->diffInSeconds($this->activity_at));
        $diffInMinutes = floor($diffInSeconds / 60);

        if ($diffInMinutes < 10 && $this->user->character->id == $this->id) {
            return true;
        } else {
            return false;
        }
    }

    public function getOnlineTitle(): string
    {
        if (!$this->activity_at) {
            return 'Небыл активен';
        }

        $now = now();
        $diffInSeconds = abs($now->diffInSeconds($this->activity_at));
        $diffInMinutes = floor($diffInSeconds / 60);
        $diffInHours = floor($diffInMinutes / 60);
        $diffInDays = floor($diffInHours / 24);

        if ($diffInMinutes < 2 && $this->user->currentCharacter()->id == $this->id) {
            return 'Онлайн';
        }

        if ($diffInMinutes < 10) {
            return 'Отошел';
        }

        if ($diffInMinutes < 60) {
            return $diffInMinutes . ' м. назад';
        }

        if ($diffInHours < 24) {
            return $diffInHours . ' ч. назад';
        }

        return $diffInDays . ' дн. назад';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setActivityAt(): void
    {
        $this->activity_at = now();
        $this->save();
    }

    public function getActivityAt()
    {
        return $this->activity_at;
    }

    public function timeToNextAction()
    {
        return max(0, now()->diffInSeconds($this->next_action_at, false));
    }

    public function isAvailable(): bool
    {
        return now()->greaterThan($this->next_action_at);
    }

    public function setDelayToNextAction($seconds): void
    {
        $validSeconds = $seconds - ($seconds * $this->getMoveSpeed() / 100);
        $this->next_action_at = now()->addSeconds($validSeconds);
        $this->save();
    }

    public function increaseDelayToNextAction($seconds): void
    {
        $validSeconds = $seconds - ($seconds * $this->getMoveSpeed() / 100);
        $this->next_action_at += now()->addSeconds($validSeconds);
        $this->save();
    }

    public function decreaseDelayToNextAction($seconds): void
    {
        $validSeconds = $seconds - ($seconds * $this->getMoveSpeed() / 100);
        $this->next_action_at -= now()->addSeconds($validSeconds);
        $this->save();
    }

    public function getModifierStats()
    {
        $modifiers = $this->transition->getModifierInstances();
        $modifiers = $modifiers->merge($this->getEquipmentModifiers());
        // $modifiers = $this->getEquipmentModifiers();

        return ModifierService::sumModifiers($modifiers);
    }
}
