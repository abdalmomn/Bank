<?php

namespace App\Http\Requests\Accounts;

use Illuminate\Foundation\Http\FormRequest;

class CustomerAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->hasRole('employee');
    }

    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => $this->createRules(),
            'PUT', 'PATCH', 'POST' => $this->updateRules(),
            default => []
        };
    }

    private function createRules(): array
    {
        return [
            'first_name'       => 'required|string|max:255',
            'father_name'      => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',

            'phone'            => 'required|string|unique:users,phone',
            'email'            => 'required|email|unique:users,email',

            'national_id'      => 'required|string|max:50|unique:customers,national_id',

            'birth_date'       => 'required|date|before:today',
            'birth_place'      => 'nullable|string|max:255',
            'nationality'      => 'required|string|max:100',
            'mother_name'      => 'nullable|string|max:255',
            'age'              => 'nullable|integer|min:18|max:120',
            'address'          => 'required|string',
            'occupation'       => 'nullable|string|max:255',
            'education_level'  => 'nullable|string|max:255',

            'monthly_income'   => 'nullable|numeric|min:0',
            'monthly_expenses' => 'nullable|numeric|min:0',

            'account_type_id'  => 'required|exists:account_types,id',
            'currency'         => 'required|string',
        ];
    }

    private function updateRules(): array
    {
        return [
            'first_name'       => 'sometimes|string|max:255',
            'father_name'      => 'sometimes|string|max:255',
            'last_name'        => 'sometimes|string|max:255',

            'phone'            => 'sometimes|string|unique:users,phone',
            'email'            => 'sometimes|email|unique:users,email',

            'national_id'      => 'sometimes|string|max:50',
            'birth_date'       => 'sometimes|date',
            'birth_place'      => 'sometimes|string|max:255',
            'nationality'      => 'sometimes|string|max:100',
            'mother_name'      => 'sometimes|string|max:255',
            'age'              => 'sometimes|integer|min:0',
            'address'          => 'sometimes|string',
            'occupation'       => 'sometimes|string|max:255',
            'education_level'  => 'sometimes|string|max:255',

            'monthly_income'   => 'sometimes|numeric|min:0',
            'monthly_expenses' => 'sometimes|numeric|min:0',

            'account_type_id'  => 'sometimes|exists:account_types,id',
            'currency'         => 'sometimes|string|size:3',
        ];
    }
}
