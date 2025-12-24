<?php

namespace App\Http\DTO\Transaction;

class TransactionApprovalDTO
{
    public function __construct(
        public string $decision, // approved | rejected
        public ?string $notes = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['decision'],
            $data['notes'] ?? null,
        );
    }
}
