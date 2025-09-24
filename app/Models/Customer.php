<?php

namespace App\Models;

use App\Events\Customer\CustomerDeleted;
use App\Events\Customer\CustomerSaved;
use App\Models\Traits\CanSearch;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use CanSearch;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    protected $dispatchesEvents = [
        'saved' => CustomerSaved::class,
        'deleted' => CustomerDeleted::class,
    ];

    public function name(): Attribute
    {

        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['first_name'].' '.$attributes['last_name']
        );

    }

    public function revisions(): HasMany
    {
        return $this->hasMany(CustomerRevision::class);
    }
}
