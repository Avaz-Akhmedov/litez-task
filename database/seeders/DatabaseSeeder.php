<?php

namespace Database\Seeders;

use Database\Seeders\Catalog\CategorySeeder;
use Database\Seeders\Catalog\ProductSeeder;
use Database\Seeders\Crm\ClientSeeder;
use Database\Seeders\Crm\TaskSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;


    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ClientSeeder::class,
            TaskSeeder::class,
        ]);

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            ProductAttributeSeeder::class,
            StockSeeder::class,
            StockMovementSeeder::class
        ]);
    }
}
