<?php

namespace App\Http\DTO\Account;

class CustomerAccountDTO
{
    public function __construct(
        public string  $first_name,
        public ?string $father_name,
        public ?string $last_name,
        public ?string $phone,
        public ?string $email,

        public ?string $national_id,
        public ?string $birth_date,
        public ?string $birth_place,
        public ?string $nationality,
        public ?string $mother_name,
        public ?int    $age,
        public ?string $address,
        public ?string $occupation,
        public ?string $education_level,
        public ?float  $monthly_income,
        public ?float  $monthly_expenses,

        public int     $account_type_id,
        public string  $currency
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['first_name'],
            $data['father_name']     ?? null,
            $data['last_name']       ?? null,
            $data['phone']           ?? null,
            $data['email']           ?? null,

            $data['national_id']     ?? null,
            $data['birth_date']      ?? null,
            $data['birth_place']     ?? null,
            $data['nationality']     ?? null,
            $data['mother_name']     ?? null,
            $data['age']             ?? null,
            $data['address']         ?? null,
            $data['occupation']      ?? null,
            $data['education_level'] ?? null,
            $data['monthly_income']  ?? null,
            $data['monthly_expenses']?? null,

            $data['account_type_id'],
            $data['currency'] ?? 'SP'
        );
    }
}
