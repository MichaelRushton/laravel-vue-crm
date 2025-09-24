<?php

namespace App\Http\Resources\SignIn;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SignInIndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ip_address' => $this->ip_address,
            'email' => $this->email,
            'user' => trim($this->first_name.' '.$this->last_name),
            'correct_password' => $this->correct_password,
            'created_at' => $this->created_at->format('d/m/Y H:i:s'),
        ];
    }
}
