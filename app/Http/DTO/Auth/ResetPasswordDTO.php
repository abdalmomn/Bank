<?php

namespace App\Http\DTO\Auth;

class ResetPasswordDTO
{
    public function __construct(
        public string $account_number,
        public string $old_password,
        public string $new_password,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['account_number'],
            $data['old_password'],
            $data['new_password'],
        );
    }
}
