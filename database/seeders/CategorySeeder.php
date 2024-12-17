<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name'=>'Vajilla',
            'description'=>'Aquí se incluyen todos los productos como platos, vasos o similares',
        ]);
        Category::create([
            'name'=>'Cubiertos',
            'description'=>'En este categoría se podrán encontrar cuchcaras, tenedores y cuchillos de diferentes tamaños y tipos',
        ]);
    }
}
