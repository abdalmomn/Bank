<?php

namespace App\Domain\Transactions\States;

use App\Models\Transaction;

abstract class TransactionState
{
    abstract public function apply(Transaction $transaction, float $amount): void;
}

