<?php

namespace Database\Seeders;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'user_id' => 1,
            'grand_total' => 110,
            'payment_method' => 'Tarjeta de crédito',
            'payment_status' => 'Pagado',
            'status' => OrderStatus::Enviado,
            'currency' => 'Euros',
            'shipping_amount' => 10,
            'shipping_method' => 'Por Seur',
            'notes' => 'Persona de contacto Sánchez',
        ]);

        Order::create([
            'user_id' => 1,
            'grand_total' => 220,
            'payment_method' => 'En efectivo',
            'payment_status' => 'Se paga en destino',
            'status' => OrderStatus::Nuevo,
            'currency' => 'Euros',
            'shipping_amount' => 20,
            'shipping_method' => 'Se enviará por correos',
            'notes' => 'Entregar en el bar de la esquina',
        ]);
    }
}
