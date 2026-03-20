<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Events\User\UserSaved;
use App\Models\Traits\CanSearch;
use App\Models\Traits\UpdateIfDirty;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use CanSearch;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use UpdateIfDirty;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'role' => UserRole::class,
            'status' => UserStatus::class,
        ];
    }

    protected $dispatchesEvents = [
        'saved' => UserSaved::class,
    ];

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            $user->uuid ??= Str::uuid();
        });
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(UserRevision::class);
    }

    public function passwordResets(): HasMany
    {
        return $this->hasMany(PasswordReset::class);
    }

    public function isAdministrator(): bool
    {
        return $this->role === UserRole::Administrator;
    }

    public function scopeWhereRole(Builder $query, ?UserRole $role): Builder
    {
        return $query->when($role, fn ($query) => $query->where('role', $role));
    }

    public function scopeWhereStatus(Builder $query, ?UserStatus $status): Builder
    {
        return $query->when($status, fn ($query) => $query->where('status', $status));
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
