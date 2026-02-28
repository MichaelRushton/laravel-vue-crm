<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SignIn extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'correct_password' => 'boolean',
            'created_at' => 'immutable_datetime',
        ];
    }

    protected static function booted(): void
    {

        static::creating(function (SignIn $sign_in) {
            $sign_in->ip_address ??= request()->ip();
            $sign_in->created_at ??= now();
        });

    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
