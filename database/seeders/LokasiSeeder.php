<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lokasi;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Ruang Arsip', 'kode' => 'RA', 'keterangan' => 'Tempat penyimpanan dokumen'],
            ['nama' => 'Ruang Baca', 'kode' => 'RB', 'keterangan' => 'Area membaca dan riset'],
            ['nama' => 'Ruang Server', 'kode' => 'RS', 'keterangan' => 'Tempat penyimpanan server dan jaringan'],
            ['nama' => 'Ruang Rapat', 'kode' => 'RR', 'keterangan' => 'Tempat rapat staf'],
        ];

        foreach ($data as $lokasi) {
            Lokasi::updateOrCreate(['nama' => $lokasi['nama']], $lokasi);
        }
    }
}
