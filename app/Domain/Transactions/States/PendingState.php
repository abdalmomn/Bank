<?php

namespace App\Domain\Transactions\States;

use App\Models\Transaction;
use App\Models\TransactionApproval;

class PendingState extends TransactionState
{
    public function apply(Transaction $transaction, float $amount): void
    {
        $transaction->status = 'pending';
        $transaction->requires_approval = true;
        $transaction->save();

        TransactionApproval::create([
            'transaction_id' => $transaction->id,
            'approver_id' => null,
            'decision' => 'pending',
        ]);
    }
}
