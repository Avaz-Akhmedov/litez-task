<?php

namespace Database\Seeders\Catalog;

use App\Models\Catalog\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roots = Category::factory(10)->create([
            'parent_id' => null,
        ]);


        foreach (range(1,10) as $i) {

            $depth = rand(1,5);
            $parent = $roots->random();

            for ($level = 1; $level <= $depth; $level++) {
                $parent = Category::factory()->create([
                    'parent_id' => $parent->id,
                ]);
            }
        }
    }
}
