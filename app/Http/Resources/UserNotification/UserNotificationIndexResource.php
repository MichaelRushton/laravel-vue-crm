<?php

namespace App\Http\Resources\UserNotification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserNotificationIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'created_at' => $this->created_at->format('d/m/Y H:i'),
        ];
    }
}
