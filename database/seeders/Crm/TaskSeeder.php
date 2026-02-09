<?php

namespace Database\Seeders\Crm;

use App\Models\Crm\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory(65)->create();
    }
}
