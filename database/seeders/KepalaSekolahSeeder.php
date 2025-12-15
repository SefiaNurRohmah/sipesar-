<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KepalaSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@sipesar.com',
            'password' => Hash::make('password'),
            'role' => 'kepala_sekolah',
            'hp' => '081234567890',
        ]);
    }
}