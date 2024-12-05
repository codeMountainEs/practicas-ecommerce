<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::create([
            'name' => 'Samsung',
            'slug'=> 'Samsung',
            'image' => 'brands/01HZS5PRD6AKRSMWY8Q69GR7H5.png'
           
        ]);

        Brand::create([
            'name' => 'Nokia',
            'slug'=> 'Nokia',
            'image' => 'brands/01HZS5BVWCDQD25KY14PEHVBD3.jpg'
           
        ]);

        Brand::create([
            'name' => 'Apple',
            'slug'=> 'Apple',
            'image' => 'brands/01HZS5CRRQH67YCBHTAFQH3Y8A.jpg'
           
        ]);

        Brand::create([
            'name' => 'Lg',
            'slug'=> 'Lg',
            'image' => 'brands/01HZS5DJ91H5MXY0MGTV5QCKGG.png'
           
        ]);

        Brand::create([
            'name' => 'Hp',
            'slug'=> 'Hp',
            'image' => 'brands/01HZS5E9BPEV43693Y2VC1YM54.jpg'
           
        ]);

        Brand::create([
            'name' => 'Sony',
            'slug'=> 'Sony',
            'image' => 'brands/01HZS5EY8Q2316BJS4MBWX2M5A.jpg'
           
        ]);
    }
}
