<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categoriaAleatoria = Category::inRandomOrder()->first();
        $brandAleatoria = Brand::inRandomOrder()->first();

         Product::create([
            'category_id'=> $categoriaAleatoria->id,
            'brand_id'=> $brandAleatoria->id,
            'name' => 'Galaxy 10',
            'slug'=> 'Galaxy-10',
            'description' => 'This is a smartphone',
            'price' => 520,
        ]);

        Product::create([
            'category_id'=> $categoriaAleatoria->id,
            'brand_id'=> $brandAleatoria->id,
            'name' => 'Galaxy 11',
            'slug'=> 'Galaxy-11',
            'description' => 'This is a smartphone',
            'price' => 650,
        ]);
    }
}
