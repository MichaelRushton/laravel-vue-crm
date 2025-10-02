<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerRevision extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

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
