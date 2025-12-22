<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\AccountType;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition()
    {
        return [
            'account_number'  => $this->faker->unique()->numerify('ACC######'),
            'account_type_id' => AccountType::inRandomOrder()->first()->id,
            'customer_id'     => Customer::inRandomOrder()->first()->id,
            'parent_id'       => null,
            'balance'         => $this->faker->randomFloat(4, 0, 100000),
            'currency'        => 'USD',
            'state'           => $this->faker->randomElement(['active','frozen']),
            'metadata'        => [],
        ];
    }
}
