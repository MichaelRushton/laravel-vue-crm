<?php

namespace App\Models;

use App\Models\Traits\CanSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use CanSearch;
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'message',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }
}
