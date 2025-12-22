<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            // Users table
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'is_active' => $this->is_active,
            'profile'   => $this->profile,

            // Customer table
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

            // Accounts table
            'accounts' => $this->customer?->accounts?->map(fn ($account) => [
                'account_number' => $account->account_number,
                'balance'        => $account->balance,
                'currency'       => $account->currency,
                'state'          => $account->state,
            ]),
        ];
    }
}
