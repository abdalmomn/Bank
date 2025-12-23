<?php

namespace App\Domain\Transactions\Fees;

use App\Models\Transaction;

interface FeeStrategyInterface
{
    public function calculate($amount, Transaction $transaction): float;
}
