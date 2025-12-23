<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        $from = Account::inRandomOrder()->first();
        $to   = Account::where('id', '!=', $from->id)->inRandomOrder()->first();

        return [
            'reference'          => strtoupper(Str::random(12)),
            'from_account_id'    => $from?->id,
            'to_account_id'      => $to?->id,
            'amount'             => $this->faker->randomFloat(4, 10, 5000),
            'currency'           => 'USD',
            'type'               => $this->faker->randomElement([
                'deposit','withdraw','transfer'
            ]),
            'status'             => 'completed',
            'initiator_id'       => User::inRandomOrder()->first()->id,
            'requires_approval'  => false,
            'metadata'           => [],
        ];
    }
}

