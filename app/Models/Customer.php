<?php

declare(strict_types=1);

namespace App\Models;

use App\Events\Customer\CustomerSaved;
use App\Models\Traits\CanSearch;
use App\Models\Traits\UpdateIfDirty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Customer extends Model
{
    use CanSearch;
    use HasFactory;
    use SoftDeletes;
    use UpdateIfDirty;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    protected $dispatchesEvents = [
        'saved' => CustomerSaved::class,
    ];

    protected static function booted(): void
    {
        static::creating(function (Customer $customer) {
            $customer->uuid ??= Str::uuid();
        });
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(CustomerRevision::class);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
