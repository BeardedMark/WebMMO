<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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


    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function checkCharacter(): bool
    {
        return isset($this->character);
    }

    public function characters()
    {
        return $this->hasMany(Character::class);
    }
    public function setCharacterById($id)
    {
        $this->character_id = $id;
        $this->save();
    }

    public function hideouts()
    {
        return $this->hasMany(Hideout::class);
    }

    public function hideoutLocations()
    {
        return $this->hideouts()
            ->with('location')
            ->get()
            ->pluck('location')
            ->filter();
    }


    public function getHideoutAtCurrentLocation()
    {
        if (!$this->checkCharacter()) {
            return null;
        }

        return $this->hideouts()
            ->where('location_id', $this->character->currentLocation()->id)
            ->first();
    }
}
