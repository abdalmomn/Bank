<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLightResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'account_number' => $this->account?->account_number,
            'first_name'     => $this->customer?->first_name,
            'last_name'      => $this->customer?->last_name,
        ];
    }
}
