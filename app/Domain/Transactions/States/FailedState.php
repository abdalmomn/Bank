<?php

namespace App\Domain\Transactions\States;

use App\Models\Transaction;

class FailedState extends TransactionState
{
    public function apply(Transaction $transaction, float $amount): void
    {
        $transaction->status = 'failed';
        $transaction->requires_approval = false;
        $transaction->save();
    }
}
