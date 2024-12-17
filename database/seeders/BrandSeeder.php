<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::create([
            'name'=>'Renberg',
            'description'=>'Renberg es una marca de origen sueco que se destaca por su relación calidad-precio. Sus cuberterías combinan el acero inoxidable con mangos de polipropileno en colores vibrantes, aportando un toque de originalidad a tu mesa.',
            'logo' =>"Renberg.jpeg"
        ]);
        Brand::create([
            'name'=>'Zwilling',
            'description'=>'La marca alemana Zwilling es reconocida internacionalmente por su excelente calidad. Sus cuberterías, fabricadas en acero inoxidable 18/10, son sinónimo de resistencia y elegancia',
            'logo' =>"Zwilling.jpeg"
        ]);
        Brand::create([
            'name'=>'Arcos',
            'description'=>'Arcos es otra marca española con gran prestigio. Famosa por sus cuchillos, la cubertería Arcos destaca por su gran calidad y diseño elegante.',
            'logo' =>"Arcos.jpeg"
        ]);
        Brand::create([
            'name'=>'Exzact',
            'description'=>'Exzact es una marca británica que ofrece cuberterías de diseño moderno y minimalista. Sus productos, asequibles y de buena calidad, son perfectos para el día a día.',
            'logo' =>"Exzact.jpeg"
        ]);

    }
}
