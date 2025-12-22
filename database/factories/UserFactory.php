<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name'       => $this->faker->name(),
            'email'      => $this->faker->unique()->safeEmail(),
            'password'   => Hash::make('password'),
            'phone'      => $this->faker->unique()->phoneNumber(),
            'profile'    => [
                'address' => $this->faker->address(),
            ],
            'is_active'  => true,
            'created_by' => null,
            'updated_by' => null,
        ];
    }
}


