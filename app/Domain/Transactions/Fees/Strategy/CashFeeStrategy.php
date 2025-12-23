<?php

namespace App\Domain\Transactions\Fees\Strategy;

use App\Domain\Transactions\Fees\FeeStrategyInterface;
use App\Models\Transaction;

class CashFeeStrategy implements FeeStrategyInterface
{
    public function calculate($amount, Transaction $transaction): float
    {
        $fee = $amount * 0.005;
        return max($fee, 5);
    }
}
