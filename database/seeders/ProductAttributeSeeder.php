<?php

namespace Database\Seeders;

use App\Models\Catalog\ProductAttribute;
use Illuminate\Database\Seeder;

class ProductAttributeSeeder extends Seeder
{

    public function run(): void
    {
        ProductAttribute::factory(100)->create();
    }
}
