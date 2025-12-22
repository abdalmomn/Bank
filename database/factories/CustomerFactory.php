<?php
namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition()
    {
        return [
            'user_id'           => User::pluck('id')->random(),
            'first_name'        => $this->faker->firstName(),
            'father_name'       => $this->faker->firstName(),
            'last_name'         => $this->faker->lastName(),
            'national_id'       => $this->faker->numerify('##########'),
            'birth_date'        => $this->faker->date(),
            'birth_place'       => $this->faker->city(),
            'nationality'       => $this->faker->country(),
            'mother_name'       => $this->faker->firstNameFemale(),
            'age'               => $this->faker->numberBetween(18, 70),
            'address'           => $this->faker->address(),
            'phone'             => $this->faker->phoneNumber(),
            'email'             => $this->faker->safeEmail(),
            'occupation'        => $this->faker->jobTitle(),
            'education_level'   => $this->faker->randomElement(['High School','Bachelor','Master']),
            'monthly_income'    => $this->faker->randomFloat(2, 300, 5000),
            'monthly_expenses'  => $this->faker->randomFloat(2, 100, 3000),
            'kyc_status'        => $this->faker->randomElement(['pending','verified','rejected']),
            'metadata'          => [
                'source' => 'seed',
            ],
        ];
    }
}
