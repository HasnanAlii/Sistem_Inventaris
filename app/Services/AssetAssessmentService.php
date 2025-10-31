<?php

namespace App\Services;

use App\Models\Aset;

class AssetAssessmentService
{
    /**
     * Hitung skor dan status kelayakan aset.
     */
    public function assess(Aset $aset): array
    {
        $usia = now()->diffInYears($aset->tanggal_perolehan);
        $umurEkonomis = $aset->umur_ekonomis ?? 5;
        $jumlahPerbaikan = $aset->maintenanceLogs()->count();

        // Bobot penilaian
        $bobotUsia = 0.4;
        $bobotKondisi = 0.4;
        $bobotPerbaikan = 0.2;

        $nilaiUsia = max(0, 100 - (($usia / $umurEkonomis) * 100));
        $nilaiKondisi = match ($aset->kondisi) {
            'baru' => 100,
            'baik' => 85,
            'rusak_ringan' => 60,
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
            ($nilaiUsia * $bobotUsia) +
            ($nilaiKondisi * $bobotKondisi) +
            ($nilaiPerbaikan * $bobotPerbaikan),
            2
        );

        $status = match (true) {
            $skor >= 80 => 'Layak',
            $skor >= 60 => 'Perlu Perbaikan',
            default => 'Tidak Layak',
        };

        return [
            'aset_id' => $aset->id,
            'nama' => $aset->nama,
            'skor' => $skor,
            'status' => $status,
            'usia' => $usia,
            'jumlah_perbaikan' => $jumlahPerbaikan,
        ];
    }
}
