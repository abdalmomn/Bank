<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        $admin = User::factory()->create([
            'email' => 'admin@system.test',
        ]);
        $admin->assignRole('admin');

        // Employees
        User::factory(3)->create()->each(function ($user) use ($admin) {
            $user->assignRole('employee');
            $user->update(['created_by' => $admin->id]);
        });

        // Customers
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('customer');
        });
    }
}

