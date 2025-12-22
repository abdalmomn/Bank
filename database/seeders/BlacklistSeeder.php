<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blacklist;

class BlacklistSeeder extends Seeder
{
    public function run()
    {
        Blacklist::factory()->count(10)->create();
    }
}
