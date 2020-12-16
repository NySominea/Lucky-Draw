<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserAndRolePermissionSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(PhonesTableSeeder::class);
        $this->call(PrizesTableSeeder::class);
    }
}
