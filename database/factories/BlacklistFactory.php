<?php

namespace Database\Factories;

use App\Models\Blacklist;
use App\Models\User;
use App\Models\Customer;
use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlacklistFactory extends Factory
{
    protected $model = Blacklist::class;

    public function definition()
    {
        // اختار كائن عشوائي عشان morph
        $blacklistable = $this->faker->randomElement([
            User::inRandomOrder()->first(),
            Customer::inRandomOrder()->first(),
            Account::inRandomOrder()->first()
        ]);

        return [
            'reason'             => $this->faker->sentence(),
            'banned_at'          => now(),
            'expires_at'         => $this->faker->optional()->dateTimeBetween('+1 days', '+1 year'),
            'blacklistable_id'   => $blacklistable->id,
            'blacklistable_type' => get_class($blacklistable),
        ];
    }
}
