<?php

namespace Database\Seeders;

use App\Models\Prize;
use Illuminate\Database\Seeder;

class PrizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Prize::create(['name' => 'Air Conditioner']);
        Prize::create(['name' => 'Refrigerator']);
        Prize::create(['name' => 'Phone']);
        Prize::create(['name' => 'Sofa']);
        Prize::create(['name' => 'Water Bottle']);
    }
}
