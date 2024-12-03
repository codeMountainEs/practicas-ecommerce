<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define los roles que quieres crear
        $roles = [ 'admin', 'cliente' ];
        // Crea cada rol en la base de datos
        foreach ($roles as $role) { Role::create(['name' => $role]); }
    }
}
