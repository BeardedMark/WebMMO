<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Domains\Characters\Models\Character;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'login',
        'email',
        'password',
        'activity_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->login;
    }

    public function getTitle()
    {
        return $this->login;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getRoleTitle()
    {
        return $this->is_admin ? 'Администратор' : 'Пользователь';
    }
    public function currentCharacter()
    {
        return $this->characters()->where('is_current', true)->first();
    }

    public function characters()
    {
        return $this->hasMany(Character::class);
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
}
