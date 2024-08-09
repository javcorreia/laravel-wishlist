<?php

namespace Workbench\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 10; $i++) {
            $this->call([
                ProductsSeeder::class,
                UserSeeder::class,
            ]);
        }
    }
}
