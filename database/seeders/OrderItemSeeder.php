<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $itemAleatorio = Product::inRandomOrder();
        $primero = $itemAleatorio->first();
        $segundo = $primero->skip(1)->take(1)->first();

        OrderItem::create([
            'order_id' => 1,
            'product_id' => $primero->id,
            'quantity' => 4,
            'unit_amount' => 11,
            'total_amount' => 44,
        ]);

        OrderItem::create([
            'order_id' => 1,
            'product_id' => $segundo->id,
            'quantity' => 6,
            'unit_amount' => 11,
            'total_amount' => 66,
        ]);

        OrderItem::create([
            'order_id' => 2,
            'product_id' => $segundo->id,
            'quantity' => 8,
            'unit_amount' => 10,
            'total_amount' => 80,
        ]);

        OrderItem::create([
            'order_id' => 2,
            'product_id' => $primero->id,
            'quantity' => 10,
            'unit_amount' => 14,
            'total_amount' => 140,
        ]);
    }
}
