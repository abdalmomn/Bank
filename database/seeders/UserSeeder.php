<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@bank.test'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('12345678'),
                'is_active' => true,
                'profile' => ['type' => 'admin'],
            ]
        );
        $admin->assignRole('admin');

        $employee = User::firstOrCreate(
            ['email' => 'employee@bank.test'],
            [
                'name' => 'Bank Employee',
                'password' => Hash::make('12345678'),
                'is_active' => true,
                'profile' => ['type' => 'employee'],
            ]
        );
        $employee->assignRole('employee');

        $customerUser = User::firstOrCreate(
            ['email' => 'customer@bank.test'],
            [
                'name' => 'Fixed Test Customer',
                'password' => Hash::make('12345678'),
                'phone' => '0999999999',
                'is_active' => true,
                'profile' => ['type' => 'customer'],
            ]
        );
        $customerUser->assignRole('customer');
    }
}

