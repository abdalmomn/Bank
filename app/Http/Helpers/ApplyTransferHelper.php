<?php

namespace App\Http\Helpers;

use App\Models\Transaction;

class ApplyTransferHelper
{
    public function applyTransactionEffect(Transaction $transaction): void
    {
        match ($transaction->type) {
            'deposit' => $transaction->toAccount->increment('balance', $transaction->amount),
            'withdraw' => $transaction->fromAccount->decrement('balance', $transaction->amount),
            'transfer' => $this->applyTransfer($transaction),
            default => null
        };
    }

    public function applyTransfer(Transaction $transaction): void
    {
        $transaction->fromAccount->decrement('balance', $transaction->amount);
        $transaction->toAccount->increment('balance', $transaction->amount);
    }
}
