<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Account\AccountResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
{
    // App\Http\Resources\User\UserDetailsResource.php
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'is_active' => $this->is_active,
            'profile'   => $this->profile,
            'accounts' => AccountResource::collection(
                $this->accounts ?? collect()
            ),
            ];
    }
}
