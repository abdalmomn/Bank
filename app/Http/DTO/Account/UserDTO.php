<?php

namespace App\Http\DTO\Account;

class UserDTO
{
    public function __construct(
        public string  $name,
        public string  $email,
        public ?string $phone,
        public ?string $password,
        public string $account_type_id,
        public ?string $profile = null,

    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['password'] ?? null,
            $data['account_type_id'],
            $data['profile'] ?? null
        );
    }
}
