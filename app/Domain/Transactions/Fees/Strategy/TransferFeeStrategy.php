<?php

namespace App\Domain\Transactions\Fees\Strategy;

use App\Domain\Transactions\Fees\FeeStrategyInterface;
use App\Models\Transaction;

class TransferFeeStrategy implements FeeStrategyInterface
{
    public function calculate($amount, Transaction $transaction): float
    {
        return $amount * 0.01;
    }
}
