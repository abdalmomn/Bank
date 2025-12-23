<?php

namespace App\Http\DTO\Account;

class TransferDTO
{
    public string $fromAccountNumber;
    public string $toAccountNumber;
    public float $amount;
    public ?string $narration;

    public function __construct(array $data)
    {
        $this->fromAccountNumber = $data['from_account_number'];
        $this->toAccountNumber = $data['to_account_number'];
        $this->amount = $data['amount'];
        $this->narration = $data['narration'] ?? null;
    }
}
