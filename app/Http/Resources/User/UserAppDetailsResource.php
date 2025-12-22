<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Account\AccountResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAppDetailsResource extends JsonResource
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

            'customer' => [
                'first_name'       => $this->customer?->first_name,
                'father_name'      => $this->customer?->father_name,
                'last_name'        => $this->customer?->last_name,
                'national_id'      => $this->customer?->national_id,
                'birth_date'       => $this->customer?->birth_date,
                'nationality'      => $this->customer?->nationality,
                'phone'            => $this->customer?->phone,
                'email'            => $this->customer?->email,
                'kyc_status'       => $this->customer?->kyc_status,
                'monthly_income'   => $this->customer?->monthly_income,
                'monthly_expenses' => $this->customer?->monthly_expenses,
            ],

            'account'   => $this->when(
                isset($this->additional['account']),
                new AccountResource($this->additional['account'] ?? null)
            ),
        ];
    }
}
