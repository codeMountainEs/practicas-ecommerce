<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Smartphone',
            'slug'=> 'Smartphone',
           
        ]);

        Category::create([
            'name' => 'PC',
            'slug'=> 'PC',
           
        ]);

        Category::create([
            'name' => 'Tablet',
            'slug'=> 'Tablet',
           
        ]);

        Category::create([
            'name' => 'Televisor',
            'slug'=> 'Televisor',
           
        ]);

        Category::create([
            'name' => 'Laptops',
            'slug'=> 'Laptops',
           
        ]);

        Category::create([
            'name' => 'Smartwatches',
            'slug'=> 'Smartwatches',
           
        ]);
    }
}
