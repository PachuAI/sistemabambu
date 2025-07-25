<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProvinciasSeeder::class,
            CiudadSeeder::class,
            NivelDescuentoSeeder::class,
            ProductoSeeder::class,
            ClienteSeeder::class,
        ]);

        // Crear usuario admin para Filament
        User::factory()->create([
            'name' => 'Admin BAMBU',
            'email' => 'admin@bambu.com',
            'password' => bcrypt('admin123'),
        ]);
    }
}
