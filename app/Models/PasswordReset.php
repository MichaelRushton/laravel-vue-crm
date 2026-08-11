<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[WithoutTimestamps]
class PasswordReset extends Model
{
    use HasFactory;
    use HasUuids;
    use MassPrunable;
    use SoftDeletes;

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

    public function prunable(?CarbonInterface $from = null): Builder
    {
        return static::where('created_at', '<', $from ?: today()->subDays(365));
    }
}
