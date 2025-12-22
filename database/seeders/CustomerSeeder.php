<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'customer@bank.test')->first();

        Customer::firstOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => 'Test',
                'father_name' => 'User',
                'last_name' => 'Customer',
                'national_id' => '123456789',
                'birth_date' => '1995-01-01',
                'birth_place' => 'Damascus',
                'nationality' => 'Syrian',
                'mother_name' => 'Mother',
                'age' => 30,
                'address' => 'Damascus',
                'phone' => '0999999999',
                'email' => 'customer@bank.test',
                'occupation' => 'Engineer',
                'education_level' => 'Bachelor',
                'monthly_income' => 1500,
                'monthly_expenses' => 700,
                'kyc_status' => 'verified',
                'metadata' => ['seeded' => true],
            ]
        );

        // Random customers
        Customer::factory(10)->create();
    }
}

