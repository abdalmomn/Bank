<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLightResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $account = $this->customer?->accounts()->first();

        if (!$account) {
            $account = $this->accounts()->first(); // لازم تعمل علاقة accounts في الـ User
        }

        return [
            'account_number' => $account?->account_number,
            'name'     => $this->name,
            'balance'      => $account?->balance,
        ];
    }
}
