<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\AtkLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtkLogController extends Controller
{
    // 🔹 Menampilkan semua log ATK (untuk admin)
    public function allLogs()
    {
        $logs = AtkLog::with('atk')->latest()->paginate(10);
        return view('atk_logs.index', compact('logs'));
    }

    // 🔹 Menampilkan log milik user yang sedang login
  public function list()
{
    $user = Auth::user();

    $query = AtkLog::with('atk');

    // Jika user bukan petugas, tampilkan hanya data miliknya sendiri
    if (! $user->hasRole('petugas')) {
        $query->where('user_id', $user->id);
    }

    $logs = $query->latest()->paginate(10);

    return view('atks.list', compact('logs'));
}

    // 🔹 Menampilkan detail satu log
    public function show(AtkLog $atkLog)
    {
        return view('atk_logs.show', compact('atkLog'));
    }

  

    // ✅ Menyetujui permintaan ATK dan mengurangi stok
    public function approve(AtkLog $atkLog)
    {
        // Pastikan log memiliki relasi ke ATK
        if (!$atkLog->atk) {
            return back()->with('error', 'Data ATK tidak ditemukan.');
        }

        $atk = $atkLog->atk;

        // Cek apakah stok cukup
        if ($atk->stok < $atkLog->jumlah) {
            return back()->with('error', 'Stok ATK tidak mencukupi untuk disetujui.');
        }

        // Kurangi stok
        $atk->stok -= $atkLog->jumlah;
        $atk->save();

        // Update status log
        $atkLog->update(['status' => 'Disetujui']);

        return back()->with('success', 'Permintaan ATK telah disetujui dan stok berhasil dikurangi.');
    }


    // ❌ Menolak permintaan ATK
    public function reject(AtkLog $atkLog)
    {
        $atkLog->update(['status' => 'Ditolak']);
        return back()->with('error', 'Permintaan ATK telah ditolak.');
    }
}
