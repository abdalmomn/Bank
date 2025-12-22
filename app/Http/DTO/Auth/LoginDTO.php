<?php

namespace App\Http\DTO\Auth;

class LoginDTO
{
    public function __construct(
        public string $account_number,
        public string $password,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['account_number'],
            $data['password'],
        );
    }
}
