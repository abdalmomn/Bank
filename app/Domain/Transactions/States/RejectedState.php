<?php

namespace App\Domain\Transactions\States;

use App\Models\Transaction;

class RejectedState extends TransactionState
{
    public function apply(Transaction $transaction, float $amount): void
    {
        $transaction->status = 'rejected';
        $transaction->requires_approval = false;
        $transaction->save();
    }
}
