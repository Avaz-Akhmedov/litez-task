<?php

namespace Database\Seeders\Crm;

use App\Models\Crm\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::factory(30)->create();
    }
}
