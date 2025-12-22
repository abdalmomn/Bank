<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Account\AccountResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardUserDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'is_active' => $this->is_active,
            'profile'   => $this->profile,

            'account'   => $this->when(
                isset($this->additional['account']),
                new AccountResource($this->additional['account'] ?? null)
            ),

            'roles' => $this->roles->map(fn($role) => new RoleResource($role)),
        ];
    }
}

