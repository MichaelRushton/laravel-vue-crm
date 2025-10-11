<?php

namespace App\Models;

use App\Events\Customer\CustomerSaved;
use App\Models\Traits\CanSearch;
use App\Models\Traits\UpdateIfDirty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function revisions(): HasMany
    {
        return $this->hasMany(CustomerRevision::class);
    }
}
