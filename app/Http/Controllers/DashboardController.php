<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aset;
use App\Models\Atk;
use App\Models\AtkProcurement;
use App\Models\AsetLoan;
use App\Models\AsetLog;
use App\Models\AtkLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('petugas')) {
            $totalAset = Aset::count();
            $totalAtk = Atk::count();
            $totalPeminjaman = AsetLoan::where('status', 'Disetujui')->count();

            $stokMenipis = Atk::whereColumn('stok', '<', 'stok_minimum')->count();
            $daftarStokMenipis = Atk::whereColumn('stok', '<', 'stok_minimum')->get();

            $asetRusak = Aset::where('kondisi', 'Rusak')->count();
            $daftarAsetRusak = Aset::where('kondisi', 'Rusak')->get();

            $pengadaanAtk = AtkProcurement::latest()->take(5)->get();
            $pengadaanAset = AsetLog::latest()->take(5)->get();

            return view('dashboard_admin', compact(
                'totalAset',
                'totalAtk',
                'totalPeminjaman',
                'stokMenipis',
                'daftarStokMenipis',
                'asetRusak',
                'daftarAsetRusak',
                'pengadaanAtk',
                'pengadaanAset'
            ));
        }


        elseif ($user->hasRole('pegawai')) {
            $peminjamanAset = AsetLoan::where('user_id', $user->id)
                ->with('aset')
                ->latest()
                ->take(5)
                ->get();

            $permintaanAtk = AtkLog::where('user_id', $user->id)
                ->with('atk')
                ->latest()
                ->take(5)
                ->get();

            $asetBelumDikembalikan = AsetLoan::where('user_id', $user->id)
            ->where('status', 'Disetujui')
            ->with('aset')
            ->get();

            $notifikasiAset = $asetBelumDikembalikan->map(function ($loan) {
                return [
                    'nama_aset' => $loan->aset->nama ?? 'Aset Tidak Diketahui',
                    'sisa_hari' => (int) Carbon::now()->diffInDays(
                    Carbon::parse($loan->tanggal_harus),
                    false
                ),

                ];
            });

            $belumDikembalikan = $notifikasiAset->count();

            return view('dashboard', compact(
                'peminjamanAset',
                'permintaanAtk',
                'notifikasiAset',
                'belumDikembalikan'
            ));
        }

     
        abort(403, 'Anda tidak memiliki akses ke dashboard.');
    }
}
