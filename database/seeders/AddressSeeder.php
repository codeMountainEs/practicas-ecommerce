<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Address::create([
            'order_id' => 2,
            'first_name' => 'Nombre del segundo pedido',
            'last_name' => 'Último nombre del segundo pedido',
            'phone' => 'Teléfono del segundo',
            'street_address' => 'Dirección del segundo pedido',
            'city' => 'Ciudad del segundo',
            'state' => 'Estado del segundo',
            'zip_code' => 'Código postal del segundo',
        ]);

        Address::create([
            'order_id' => 1,
            'first_name' => 'Nombre del primer pedido',
            'last_name' => 'Último nombre del primer pedido',
            'phone' => 'Teléfono del primero',
            'street_address' => 'Dirección del primer pedido',
            'city' => 'Ciudad del primero',
            'state' => 'Estado del primero',
            'zip_code' => 'Código postal del primero',
        ]);
    }
}
