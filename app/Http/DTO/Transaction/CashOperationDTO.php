<?php

namespace App\Http\DTO\Transaction;

class CashOperationDTO
{
    public function __construct(
        public string $accountNumber,
        public float $amount,
        public ?string $narration = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            accountNumber: $data['account_number'],
            amount: $data['amount'],
            narration: $data['narration'] ?? null
        );
    }
}
