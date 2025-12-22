<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            CustomerSeeder::class,
            AccountTypeSeeder::class,
            AccountSeeder::class,
            TransactionSeeder::class,
            LedgerEntrySeeder::class,
            TransactionApprovalSeeder::class,
            AuditLogSeeder::class,
            BlacklistSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
