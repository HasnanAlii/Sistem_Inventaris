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

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ==============================
        // 🔹 DASHBOARD UNTUK PETUGAS
        // ==============================
        if ($user->hasRole('petugas')) {
            // Statistik utama
            $totalAset = Aset::count();
            $totalAtk = Atk::count();
            $totalPeminjaman = AsetLoan::where('status', 'Disetujui')->count();

            // Notifikasi stok menipis (stok < stok_minimum)
            $stokMenipis = Atk::whereColumn('stok', '<', 'stok_minimum')->count();
            $daftarStokMenipis = Atk::whereColumn('stok', '<', 'stok_minimum')->get();

            // Notifikasi aset rusak
            $asetRusak = Aset::where('kondisi', 'Rusak')->count();
            $daftarAsetRusak = Aset::where('kondisi', 'Rusak')->get();

            // Data pengadaan terbaru
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

        // ==============================
        // 🔹 DASHBOARD UNTUK PEGAWAI
        // ==============================
        elseif ($user->hasRole('pegawai')) {
            // Riwayat peminjaman aset oleh user
            $peminjamanAset = AsetLoan::where('user_id', $user->id)
                ->with('aset')
                ->latest()
                ->take(5)
                ->get();

            // Riwayat permintaan ATK oleh user
            $permintaanAtk = AtkLog::where('user_id', $user->id)
                ->with('atk')
                ->latest()
                ->take(5)
                ->get();

            // Hitung aset yang belum dikembalikan
            $belumDikembalikan = AsetLoan::where('user_id', $user->id)
                ->where('status', 'Belum Dikembalikan')
                ->count();

            return view('dashboard', compact(
                'peminjamanAset',
                'permintaanAtk',
                'belumDikembalikan'
            ));
        }

        // ==============================
        // 🔹 DEFAULT (tidak punya role)
        // ==============================
        abort(403, 'Anda tidak memiliki akses ke dashboard.');
    }
}
