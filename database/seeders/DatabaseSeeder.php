<?php

namespace Database\Seeders;

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
            TaskSeeder::class
        ]);
    }
}
