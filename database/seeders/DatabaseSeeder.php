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
        // Memanggil seeder lainnya
        $this->call([
            AdminSeeder::class,
            KepalaSekolahSeeder::class,
        ]);

        // Contoh: Membuat user tambahan dengan factory (jika diperlukan)
        // User::factory(10)->create();
    }
}
