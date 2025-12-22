<?php

namespace Database\Factories;

use App\Models\TransactionApproval;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionApprovalFactory extends Factory
{
    protected $model = TransactionApproval::class;

    public function definition()
    {
        return [
            'transaction_id' => Transaction::inRandomOrder()->first()->id,
            'approver_id'    => User::inRandomOrder()->first()->id,
            'decision'       => $this->faker->randomElement(['approved','rejected','pending']),
            'notes'          => $this->faker->optional()->sentence(),
        ];
    }
}

