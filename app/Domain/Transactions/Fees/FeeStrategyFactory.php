<?php

namespace App\Domain\Transactions\Fees;

use App\Domain\Transactions\Fees\Strategy\CashFeeStrategy;
use App\Domain\Transactions\Fees\Strategy\TransferFeeStrategy;

class FeeStrategyFactory
{
    public static function make($type): FeeStrategyInterface
    {
        return match ($type) {
            'deposit', 'withdraw' => new CashFeeStrategy(),
            'transfer'            => new TransferFeeStrategy(),
            default               => throw new \Exception('Invalid fee strategy'),
        };
    }
}
