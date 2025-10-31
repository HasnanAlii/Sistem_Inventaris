<?php

namespace App\Http\Controllers;

use App\Models\AtkProcurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtkProcurementController extends Controller
{
    // Tampilkan daftar pengadaan ATK
    public function index()
    {
        $procurements = AtkProcurement::with('user')->latest()->paginate(10);
        return view('atks.procurements.index', compact('procurements'));
    }

    // Form tambah pengadaan
    public function create()
    {
        return view('atks.procurements.create');
    }

    // Simpan pengadaan ATK
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pengadaan' => 'nullable|date',
        ]);

        AtkProcurement::create([
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'tanggal_pengadaan' => $request->tanggal_pengadaan,
        ]);

        return redirect()->route('logs.procurement')->with('success', 'Pengadaan ATK berhasil diajukan.');
    }

    // Update status (Disetujui / Ditolak / Selesai)
    public function updateStatus(Request $request, AtkProcurement $procurement)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak,Selesai'
        ]);

        $procurement->update(['status' => $request->status]);

        return back()->with('success', 'Status pengadaan ATK berhasil diperbarui.');
    }
}
