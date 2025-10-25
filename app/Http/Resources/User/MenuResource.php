<?php

declare(strict_types=1);

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
                MenuItem::Customers,
                'Administration' => [
                    MenuItem::Users,
                ],
            ],
            default => [
                MenuItem::Dashboard,
                MenuItem::Customers,
            ]
        };

    }

    public function jsonSerialize(?array $items = null): array
    {

        foreach ($items ?? $this->items() as $key => $item) {

            $menu[] = is_array($item) ? [
                'label' => $key,
                'items' => $this->jsonSerialize($item),
            ] : [
                'href' => $item->href(),
                'label' => $item->label(),
            ];

        }

        return $menu ?? [];

    }
}
