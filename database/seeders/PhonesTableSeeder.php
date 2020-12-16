<?php

namespace Database\Seeders;

use App\Models\Phone;
use Illuminate\Database\Seeder;

class PhonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Phone::factory()
            ->times(100)
            ->create();
    }
}
