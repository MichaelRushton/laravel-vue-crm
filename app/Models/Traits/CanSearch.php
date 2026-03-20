<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait CanSearch
{
    public function scopeSearch(
        Builder $query,
        ?string $search,
        string|array $columns
    ): void {

        if ("$search" === '') {
            return;
        }

        Str::of($search)
            ->trim()
            ->split('/ +/')
            ->each(fn ($string) => $query->where(function (Builder $query) use ($string, $columns) {

                foreach ((array) $columns as $column) {
                    $query->orWhereLike($column, "%$string%");
                }

            }));

    }
}
