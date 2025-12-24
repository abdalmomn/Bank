<?php

namespace App\Http\Requests\Transactions;

use Illuminate\Foundation\Http\FormRequest;

class TransactionApprovalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasRole(['admin']);
    }

    public function rules(): array
    {
        return [
            'decision' => ['required','in:approved,rejected'],
            'notes' => ['nullable','string','max:1000'],
        ];
    }
}
