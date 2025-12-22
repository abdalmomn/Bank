<?php

namespace App\Http\DTO\Auth;

class ActivationDTO
{
    public function __construct(
        public string $account_number,
        public string $password,
        public string $otp_code,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['account_number'],
            $data['password'],
            $data['otp_code'],
        );
    }
}
