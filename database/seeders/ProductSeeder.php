<?php

namespace Database\Seeders;

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
        Product::create([
            'name'=>'vaso',
            'description'=>'Un vaso transparente para zumo',
            'price'=>'4.32',
            'image'=>'url de imagen ficticia',
            'stock'=>'30',
            'isLimited'=>true,
        ]);
        Product::create([
            'name'=>'plato',
            'description'=>'Un plato plano de porcelana',
            'price'=>'7.90',
            'image'=>'url de imagen plato',
            'stock'=>'0',
            'isLimited'=>false,
        ]);
        Product::create([
            'name'=>'Paquete cucharas',
            'description'=>'Un paquete de de 20 cucharas soperas',
            'price'=>'12',
            'image'=>'url de imagen de cucharas',
            'stock'=>'0',
            'isLimited'=>false,
        ]);
        Product::create([
            'name'=>'Paquete de tenedores',
            'description'=>'Un paquete de de 20 tenedores grandes',
            'price'=>'10',
            'image'=>'url de imagen de tenedores',
            'stock'=>'0',
            'isLimited'=>false,
        ]);

    }
}
