<?php

namespace App\Http\Resources\User;

use App\Enums\MenuItem;
use App\Enums\UserRole;
use App\Models\User;
use JsonSerializable;

class MenuResource implements JsonSerializable
{
    public function __construct(
        public readonly User $user
    ) {}

    public function items(): array
    {

        return match ($this->user->role) {
            UserRole::Administrator => [
                MenuItem::Dashboard,
                MenuItem::Users,
                MenuItem::Customers,
            ],
            default => [
                MenuItem::Dashboard,
                MenuItem::Customers,
            ]
        };

    }

    public function jsonSerialize(): array
    {

        return array_map(fn (MenuItem $item) => [
            'href' => $item->href(),
            'label' => $item->label(),
        ], $this->items());

    }
}
