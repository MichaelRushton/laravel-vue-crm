<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SignIn extends Model
{
    public $timestamps = false;

    protected static function booted(): void
    {

        static::creating(function (SignIn $sign_in) {
            $sign_in->ip_address = request()->ip();
        });

    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
