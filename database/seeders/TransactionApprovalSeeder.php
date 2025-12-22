<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransactionApproval;

class TransactionApprovalSeeder extends Seeder
{
    public function run()
    {
        TransactionApproval::factory()->count(50)->create();
    }
}
