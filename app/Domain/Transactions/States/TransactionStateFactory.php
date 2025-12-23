<?php

namespace App\Domain\Transactions\States;

class TransactionStateFactory
{
    public static function make($amount, $type = 'normal'): TransactionState
    {
        // إذا كانت عملية عادية (deposit, withdraw, transfer)
        if ($amount > 1000000) {
            return new PendingState();
        }
        return new CompletedState();
    }

    public static function failed(): TransactionState
    {
        return new FailedState();
    }

    public static function rejected(): TransactionState
    {
        return new RejectedState();
    }
}
