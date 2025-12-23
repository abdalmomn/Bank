<?php

namespace Database\Factories;

use App\Models\LedgerEntry;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LedgerEntryFactory extends Factory
{
    protected $model = LedgerEntry::class;

    public function definition()
    {
        return [
            'transaction_id' => null,
            'account_id'     => Account::inRandomOrder()->first()->id,
            'entry_type'     => $this->faker->randomElement(['debit','credit']),
            'amount'         => $this->faker->randomFloat(4, 1, 5000),
            'currency'       => 'USD',
            'narration'      => $this->faker->sentence(),
            'metadata'       => [],
        ];
    }
}


