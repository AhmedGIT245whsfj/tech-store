<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::updateOrCreate(
            ['slug' => 'mobile-phones'],
            ['name' => 'Mobile Phones']
        );

        Category::updateOrCreate(
            ['slug' => 'laptops'],
            ['name' => 'Laptops']
        );

        Category::updateOrCreate(
            ['slug' => 'wearables-audio'],
            ['name' => 'Wearables & Audio']
        );
    }
}
