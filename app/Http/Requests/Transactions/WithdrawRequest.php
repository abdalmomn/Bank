<?php

namespace App\Http\Requests\Transactions;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasRole('employee');
    }

    public function rules(): array
    {
        return [
            'account_number' => ['required','exists:accounts,account_number'],
            'amount' => ['required','numeric','gt:0'],
            'narration' => ['nullable','string','max:255'],
        ];
    }
}
