<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LedgerEntry;

class LedgerEntrySeeder extends Seeder
{
    public function run()
    {
        LedgerEntry::factory()->count(200)->create();
    }
}
