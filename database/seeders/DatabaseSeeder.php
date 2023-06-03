<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CarSeeder;
use Database\Seeders\PartSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CarSeeder::class,
            PartSeeder::class,
        ]);
    }
}
