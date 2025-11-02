<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Aset;
use Carbon\Carbon;

class UpdateAssetAge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan assets:update-age
     *
     * @var string
     */
    protected $signature = 'assets:update-age';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hitung umur aset otomatis dalam bulan berdasarkan tanggal perolehan';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Memulai perhitungan umur aset...');

        $asets = Aset::all();

        foreach ($asets as $aset) {
            if ($aset->tanggal_perolehan) {
                $umurBulan = Carbon::parse($aset->tanggal_perolehan)->diffInMonths(now());
                // Simpan ke field umur_ekonomis jika mau update, atau ke kolom baru
                $aset->umur_ekonomis = $umurBulan; // opsional, sesuaikan field
                $aset->save();

                $this->info("Aset: {$aset->nama}, Umur: {$umurBulan} bulan");
            }
        }

        $this->info('Selesai menghitung umur aset.');

        return 0;
    }
}
