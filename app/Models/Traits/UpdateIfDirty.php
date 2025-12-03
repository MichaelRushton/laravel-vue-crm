<?php

declare(strict_types=1);

namespace App\Models\Traits;

trait UpdateIfDirty
{
    public function updateIfDirty(
        array $attributes = [],
        array $options = []
    ): bool {

        if (! $this->exists) {
            return false;
        }

        $this->fill($attributes);

        return $this->isDirty() ? $this->save($options) : false;

    }
}
