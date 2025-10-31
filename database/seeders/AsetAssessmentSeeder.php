<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aset;
use App\Models\MaintenanceLog;
use Carbon\Carbon;

class AsetAssessmentSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh aset
        $aset = Aset::create([
            'nama' => 'Laptop Lenovo ThinkPad',
            'kategori_id' => 1,
            'merek' => 'Lenovo',
            'tipe' => 'ThinkPad E14',
            'serial_number' => 'SN12345',
            'tanggal_perolehan' => Carbon::now()->subYears(4),
            'umur_ekonomis' => 5,
            'harga' => 12000000,
            'lokasi_id' => 1,
            'kondisi' => 'baik',
            'nomor_inventaris' => 'INV-LAP/2021/0001',
        ]);

        // Riwayat perbaikan
        MaintenanceLog::create([
            'aset_id' => $aset->id,
            'tanggal' => Carbon::now()->subMonths(10),
            'jenis_perbaikan' => 'Ganti keyboard',
            'biaya' => 500000,
            'keterangan' => 'Perbaikan minor',
        ]);

        MaintenanceLog::create([
            'aset_id' => $aset->id,
            'tanggal' => Carbon::now()->subMonths(4),
            'jenis_perbaikan' => 'Service baterai',
            'biaya' => 800000,
            'keterangan' => 'Kapasitas menurun',
        ]);
    }
}
