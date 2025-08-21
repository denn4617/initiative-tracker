<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Initiative;

class InitiativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Initiative::factory()->count(5)->create();
    }
}
