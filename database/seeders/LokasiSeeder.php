<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lokasi;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Ruang Arsip', 'kode' => 'RA', 'gedung' => 'A', 'lantai' => '1', 'keterangan' => 'Tempat penyimpanan dokumen'],
            ['nama' => 'Ruang Baca', 'kode' => 'RB', 'gedung' => 'B', 'lantai' => '2', 'keterangan' => 'Area membaca dan riset'],
            ['nama' => 'Ruang Server', 'kode' => 'RS', 'gedung' => 'C', 'lantai' => '1', 'keterangan' => 'Tempat penyimpanan server dan jaringan'],
            ['nama' => 'Ruang Rapat', 'kode' => 'RR', 'gedung' => 'B', 'lantai' => '2', 'keterangan' => 'Tempat rapat staf'],
        ];

        foreach ($data as $lokasi) {
            Lokasi::updateOrCreate(['nama' => $lokasi['nama']], $lokasi);
        }
    }
}
