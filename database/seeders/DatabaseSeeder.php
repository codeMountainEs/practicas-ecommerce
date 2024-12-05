<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\CategorySeeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // User::factory(10)->create();
        $this->call(RoleSeeder::class);
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'role_id' => 1,
        ]);

        $this->call(BrandSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
    }
}
