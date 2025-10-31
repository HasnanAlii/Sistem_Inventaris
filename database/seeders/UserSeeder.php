<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // 🔹 Buat role jika belum ada
        $pegawaiRole = Role::firstOrCreate(['name' => 'pegawai']);
        $petugasRole = Role::firstOrCreate(['name' => 'petugas']);

        // 🔹 Buat user Pegawai
        $pegawai = User::firstOrCreate(
            ['email' => 'pegawai@gmail.com'],
            [
                'name' => 'Pegawai Satu',
                'password' => bcrypt('password'),
            ]
        );
        $pegawai->assignRole($pegawaiRole);

        // 🔹 Buat user Petugas
        $petugas = User::firstOrCreate(
            ['email' => 'petugas@gmail.com'],
            [
                'name' => 'Petugas Satu',
                'password' => bcrypt('password'),
            ]
        );
        $petugas->assignRole($petugasRole);

        // Info di console
        $this->command->info('✅ User Pegawai & Petugas berhasil dibuat!');
        $this->command->info('Email: pegawai@example.com | Password: password123');
        $this->command->info('Email: petugas@example.com | Password: password123');
    }
}
