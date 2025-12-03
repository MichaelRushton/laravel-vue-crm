<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerRevision extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
    ];

    protected function casts(): array
    {
        return [
            'trashed' => 'boolean',
            'created_at' => 'immutable_datetime',
        ];
    }

    protected static function booted(): void
    {

        static::creating(function (CustomerRevision $customer_revision) {
            $customer_revision->created_at ??= now();
        });

    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function impersonatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'impersonated_by');
    }
}
