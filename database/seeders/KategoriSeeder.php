<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Laptop', 'kode' => 'LAP', 'deskripsi' => 'Perangkat komputer portabel'],
            ['nama' => 'Printer', 'kode' => 'PRN', 'deskripsi' => 'Perangkat cetak dokumen'],
            ['nama' => 'Proyektor', 'kode' => 'PRO', 'deskripsi' => 'Perangkat untuk presentasi'],
            ['nama' => 'Meja Kerja', 'kode' => 'MEJ', 'deskripsi' => 'Perabot kantor untuk bekerja'],
            ['nama' => 'Kursi Kantor', 'kode' => 'KUR', 'deskripsi' => 'Tempat duduk pegawai'],
        ];

        foreach ($data as $kategori) {
            Kategori::updateOrCreate(['nama' => $kategori['nama']], $kategori);
        }
    }
}
