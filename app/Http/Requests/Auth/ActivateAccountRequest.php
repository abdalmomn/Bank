<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ActivateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'account_number' => 'required|exists:accounts,account_number',
            'password'       => 'required|string',
            'otp_code'       => 'required|string',
        ];
    }
}
