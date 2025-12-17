<?php

namespace App\Services;

use App\Models\Aset;

class AssetAssessmentService
{
    /**
     * Hitung skor dan status kelayakan aset tanpa mempertimbangkan usia.
     * Aturan khusus:
     * - Jika jumlah perbaikan > 3 => Tidak Layak
     */
    public function assess(Aset $aset): array
    {
        $jumlahPerbaikan = $aset->maintenanceLogs()->count();

        $bobotKondisi = 0.8;
        $bobotPerbaikan = 0.2;

        // Nilai kondisi
        $nilaiKondisi = match ($aset->kondisi) {
            'baru' => 100,
            'baik' => 85,
            'rusak_ringan' => 70,
            'rusak_berat' => 30,
            default => 50,
        };

        // Nilai berdasarkan jumlah perbaikan
        $nilaiPerbaikan = match (true) {
            $jumlahPerbaikan === 0 => 100,
            $jumlahPerbaikan <= 2 => 80,
            $jumlahPerbaikan === 3 => 60,
            default => 0, // > 3
        };

        // Hitung skor
        $skor = round(
            ($nilaiKondisi * $bobotKondisi) +
            ($nilaiPerbaikan * $bobotPerbaikan),
            2
        );

        // Penentuan status (hard rule)
        $status = match (true) {
            $jumlahPerbaikan > 5 => 'Tidak Layak',
            $skor >= 65 => 'Layak',
            default => 'Tidak Layak',
        };

        return [
            'aset_id' => $aset->id,
            'nama' => $aset->nama,
            'skor' => $skor,
            'status' => $status,
            'jumlah_perbaikan' => $jumlahPerbaikan,
        ];
    }
}
