<?php

namespace App\Services;

use App\Models\Aset;

class AssetAssessmentService
{
    /**
     * Hitung skor dan status kelayakan aset tanpa mempertimbangkan usia.
     */
    public function assess(Aset $aset): array
    {
        $jumlahPerbaikan = $aset->maintenanceLogs()->count();

        $bobotKondisi = 0.8;
        $bobotPerbaikan = 0.2;

        $nilaiKondisi = match ($aset->kondisi) {
            'baru' => 100,
            'baik' => 85,
            'rusak_ringan' => 70,
            'rusak_berat' => 30,
            default => 50,
        };

        $nilaiPerbaikan = match (true) {
            $jumlahPerbaikan == 0 => 100,
            $jumlahPerbaikan <= 2 => 80,
            $jumlahPerbaikan <= 4 => 60,
            default => 40,
        };

        $skor = round(
            ($nilaiKondisi * $bobotKondisi) +
            ($nilaiPerbaikan * $bobotPerbaikan),
            2
        );

        $status = match (true) {
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
