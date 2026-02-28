<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordReset extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'token',
    ];

    protected $hidden = [
        'token',
    ];

    protected function casts(): array
    {
        return [
            'token' => 'hashed',
            'created_at' => 'immutable_datetime',
            'expires_at' => 'immutable_datetime',
        ];
    }

    protected static function booted(): void
    {

        static::creating(function (PasswordReset $password_reset) {
            $password_reset->created_at ??= now();
            $password_reset->expires_at ??= now()->addMinutes(config('auth.passwords.'.config('auth.defaults.passwords').'.expire'));
        });

    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWhereNotExpired(Builder $query): Builder
    {
        return $query->where('expires_at', '>', now());
    }
}
