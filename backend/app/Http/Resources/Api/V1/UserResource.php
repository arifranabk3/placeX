<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'email_verified' => (bool) $this->email_verified_at,
            'roles' => $this->roles->pluck('slug'),
            'profile' => [
                'avatar' => $this->profile?->avatar,
                'bio' => $this->profile?->bio,
                'city' => $this->profile?->city,
                'country' => $this->profile?->country,
            ],
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}

