<?php
namespace Database\Factories;

use App\Models\AccountType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountTypeFactory extends Factory
{
    protected $model = AccountType::class;

    public function definition()
    {
        return [
            'code'   => strtoupper($this->faker->unique()->bothify('ACC_##')),
            'name'   => $this->faker->randomElement(['Current','Savings','Loan']),
            'config' => [
                'interest_rate' => $this->faker->randomFloat(2, 0, 5),
            ],
        ];
    }
}
