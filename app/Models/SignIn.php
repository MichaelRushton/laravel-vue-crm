<?php

namespace App\Models;

use App\Models\Traits\CanSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SignIn extends Model
{
    use CanSearch;
    use HasFactory;

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {

        static::creating(function (SignIn $sign_in) {
            $sign_in->ip_address ??= request()->ip();
        });

    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
