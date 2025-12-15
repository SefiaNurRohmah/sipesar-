<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Utama
        \App\Models\User::create([
            'name' => 'Admin Utama',
            'email' => 'adminutama@gmail.com',
            'hp' => '081234567890',
            'password' => Hash::make('admin123'), // Password: admin123
            'role' => 'admin',
        ]);

        // Admin Kedua
        \App\Models\User::create([
            'name' => 'Admin Kedua',
            'email' => 'adminkedua@gmail.com',
            'hp' => '082345678901',
            'password' => Hash::make('admin123'), // Password: admin123
            'role' => 'admin',
        ]);

        // Admin Ketiga
        \App\Models\User::create([
            'name' => 'Admin Ketiga',
            'email' => 'adminketiga@gmail.com',
            'hp' => '083456789012',
            'password' => Hash::make('admin123'), // Password: admin123
            'role' => 'admin',
        ]);


        // Output konfirmasi
        $this->command->info('✓ 3 Akun Admin berhasil dibuat!');
        $this->command->info('  - Admin Utama: adminutama@gmail.com | HP: 081234567890');
        $this->command->info('  - Admin Kedua: adminkedua@gmail.com | HP: 082345678901');
        $this->command->info('  - Admin Ketiga: adminketiga@gmail.com | HP: 083456789012');
        $this->command->info('  Password untuk ketiga akun: admin123');
    }
}