<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $customer = Customer::whereHas('user', fn($q) =>
        $q->where('email', 'customer@bank.test')
        )->first();

        Account::firstOrCreate(
            ['account_number' => 'ACC10000003'],
            [
                'customer_id' => $customer->id,
                'account_type_id' => 1,
                'balance' => 10000,
                'currency' => 'SYP',
                'state' => 'active',
                'metadata' => ['seeded' => true],
            ]
        );

        $admin = Customer::whereHas('user', fn($q) =>
        $q->where('email', 'admin@bank.test')
        )->first();

        Account::firstOrCreate(
            ['account_number' => 'ACC10000001'],
            [
                'customer_id' => $admin->id,
                'account_type_id' => 1,
                'balance' => 10000,
                'currency' => 'SYP',
                'state' => 'active',
                'metadata' => ['seeded' => true],
            ]
        );

        $employee = Customer::whereHas('user', fn($q) =>
        $q->where('email', 'employee@bank.test')
        )->first();

        Account::firstOrCreate(
            ['account_number' => 'ACC10000002'],
            [
                'customer_id' => $employee->id,
                'account_type_id' => 1,
                'balance' => 10000,
                'currency' => 'SYP',
                'state' => 'active',
                'metadata' => ['seeded' => true],
            ]
        );
        Account::factory(20)->create();
    }
}
