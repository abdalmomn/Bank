<?php

namespace App\Http\Requests\Accounts;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->user()?->hasRole('admin');
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
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|unique:users,phone',
            'password' => 'required|string',
            'account_type_id' => 'required|integer|exists:account_types,id',
        ];
    }
    private function updateRules(): array
    {
        return [
            'name'  => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email',
            'phone' => 'sometimes|string|unique:users,phone',
        ];
    }

}
