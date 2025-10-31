<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'nama' => 'Ranisya',
            'email' => 'admin@gmail.com',
            'role' => 'Admin',
            'password' => Hash::make('123123123'),
            'aksi' => true,
        ]);

        User::create([
            'nama' => 'Dini Rosmawati, S.E',
            'email' => 'dini@gmail.com',
            'role' => 'Admin',
            'password' => Hash::make('123123123'),
            'aksi' => true,
        ]);

        // Siswa
        User::create([
            'nama' => 'Mutia',
            'email' => 'mutia@gmail.com',
            'role' => 'Siswa',
            'password' => Hash::make('123123123'),
            'kelas' => 'XI RPL 1',
            'aksi' => true,
        ]);

        User::create([
            'nama' => 'Lala',
            'email' => 'lala@gmail.com',
            'role' => 'Siswa',
            'password' => Hash::make('123123123'),
            'kelas' => 'XI RPL 2',
            'aksi' => true,
        ]);

        User::create([
            'nama' => 'Lulu',
            'email' => 'lulu@gmail.com',
            'role' => 'Siswa',
            'password' => Hash::make('123123123'),
            'kelas' => 'XII RPL 1',
            'aksi' => true,
        ]);
    }
}