<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\AtkLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtkLogController extends Controller
{
    public function allLogs()
    {
        $logs = AtkLog::with('atk')->latest()->paginate(10);
        return view('atk_logs.index', compact('logs'));
    }

    public function list()
    {
        $user = Auth::user();

        $query = AtkLog::with('atk');

        if (! $user->hasRole('petugas')) {
            $query->where('user_id', $user->id);
        }

        $logs = $query->latest()->paginate(10);

        return view('atks.list', compact('logs'));
    }

    public function show(AtkLog $atkLog)
    {
        return view('atk_logs.show', compact('atkLog'));
    }

    public function approve(AtkLog $atkLog)
    {
        if (!$atkLog->atk) {
            return back()->with('error', 'Data ATK tidak ditemukan.');
        }

        $atk = $atkLog->atk;

        if ($atk->stok < $atkLog->jumlah) {
            return back()->with('error', 'Stok ATK tidak mencukupi untuk disetujui.');
        }

        $atk->stok -= $atkLog->jumlah;
        $atk->save();

        $atkLog->update([
        'status' => 'Disetujui',
        'tanggal_persetujuan' => Carbon::now(), 
         ]);

        return back()->with('success', 'Permintaan ATK telah disetujui dan stok berhasil dikurangi.');
    }


    public function reject(AtkLog $atkLog)
    {
        $atkLog->update(['status' => 'Ditolak']);
        return back()->with('error', 'Permintaan ATK telah ditolak.');
    }
    public function exportAtkPdf()
    {
        $logs = AtkLog::with(['atk', 'user'])->orderBy('tanggal_permintaan', 'desc')->get();

        $pdf = Pdf::loadView('atk_logs.pdf', compact('logs'));
        return $pdf->stream('riwayat_permintaan_atk.pdf'); 
    }
}
