<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Define Roles
        |--------------------------------------------------------------------------
        */
        $roles = [
            'admin',
            'employee',
            'customer',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        /*
        |--------------------------------------------------------------------------
        | Define Permissions
        |--------------------------------------------------------------------------
        */
        $permissions = [

            // Auth
            'auth.login',
            'auth.logout',

            // Profile
            'profile.view',
            'profile.update',

            // Customers
            'customers.create',
            'customers.view',
            'customers.update',

            // Accounts
            'accounts.create',
            'accounts.view',
            'accounts.update',
            'accounts.freeze',
            'accounts.close',
            'accounts.transfer',

            // Transactions
            'transactions.view',
            'transactions.deposit',
            'transactions.withdraw',
            'transactions.transfer',
            'transactions.statement',
            'transactions.approve',

            // Employees
            'employees.create',
            'employees.view',
            'employees.update',
            'employees.freeze',
            'employees.delete',

            // Monitoring & Admin
            'monitoring.view',
            'blacklist.manage',
            'commissions.manage',
            'reports.view',
            'audit_logs.view',
            'statistics.view',

            // Notifications
            'notifications.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        /*
        |--------------------------------------------------------------------------
        | Assign Permissions to Roles
        |--------------------------------------------------------------------------
        */

        // CUSTOMER
        Role::findByName('customer')->syncPermissions([
            'auth.login',
            'auth.logout',

            'profile.view',
            'profile.update',

            'accounts.view',
            'accounts.transfer',

            'transactions.view',
            'transactions.statement',

            'notifications.view',
        ]);

        // EMPLOYEE
        Role::findByName('employee')->syncPermissions([
            'customers.create',
            'customers.view',
            'customers.update',

            'accounts.create',
            'accounts.view',
            'accounts.update',
            'accounts.freeze',
            'accounts.close',

            'transactions.deposit',
            'transactions.withdraw',
            'transactions.transfer',
            'transactions.view',

            'monitoring.view',
        ]);

        // ADMIN
        Role::findByName('admin')->syncPermissions(Permission::all());

        /*
        |--------------------------------------------------------------------------
        | Create Default Users
        |--------------------------------------------------------------------------
        */

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@bank.test'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $admin->assignRole('admin');

        // Employee
        $employee = User::firstOrCreate(
            ['email' => 'employee@bank.test'],
            [
                'name' => 'Bank Employee',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $employee->assignRole('employee');

        // Customer
        $customer = User::firstOrCreate(
            ['email' => 'customer@bank.test'],
            [
                'name' => 'Test Customer',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $customer->assignRole('customer');
    }
}
