<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Events\User\UserSaved;
use App\Models\Traits\CanSearch;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use CanSearch;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    protected $dispatchesEvents = [
        'saved' => UserSaved::class,
    ];

    public function name(): Attribute
    {

        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['first_name'].' '.$attributes['last_name']
        );

    }

    public function notifications(): HasMany
    {
        return $this->hasMany(UserNotification::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(UserRevision::class);
    }

    public function isAdministrator(): bool
    {
        return $this->role === UserRole::Administrator;
    }
}
