<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\PermintaanAtk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermintaanAtkController extends Controller
{
    public function index()
    {
        $permintaans = PermintaanAtk::with(['atk', 'user'])
            ->latest()
            ->paginate(10);

        return view('permintaan_atks.index', compact('permintaans'));
    }

    public function create()
    {
        $atks = Atk::orderBy('nama_barang')->get();
        return view('permintaan_atks.create', compact('atks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'atk_id' => 'required|exists:atks,id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $atk = Atk::findOrFail($request->atk_id);

        // Cek stok cukup atau tidak
        if ($atk->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi untuk permintaan ini.');
        }

        PermintaanAtk::create([
            'atk_id' => $atk->id,
            'user_id' => Auth::id(),
            'jumlah' => $request->jumlah,
            'status' => 'menunggu',
            'tanggal_permintaan' => now(),
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('permintaan_atks.index')
            ->with('success', 'Permintaan ATK berhasil diajukan dan menunggu persetujuan.');
    }

    public function show(PermintaanAtk $permintaanAtk)
    {
        $permintaanAtk->load(['atk', 'user']);
        return view('permintaan_atks.show', compact('permintaanAtk'));
    }

    public function approve(PermintaanAtk $permintaanAtk)
    {
        DB::transaction(function () use ($permintaanAtk) {
            $atk = $permintaanAtk->atk;

            if ($atk->stok < $permintaanAtk->jumlah) {
                abort(400, 'Stok tidak mencukupi.');
            }

            // Kurangi stok
            $atk->decrement('stok', $permintaanAtk->jumlah);

            // Update status
            $permintaanAtk->update(['status' => 'disetujui']);
        });

        return redirect()->route('permintaan_atks.index')->with('success', 'Permintaan disetujui dan stok berkurang otomatis.');
    }

    public function reject(PermintaanAtk $permintaanAtk)
    {
        $permintaanAtk->update(['status' => 'ditolak']);
        return redirect()->route('permintaan_atks.index')->with('warning', 'Permintaan ditolak.');
    }

    public function destroy(PermintaanAtk $permintaanAtk)
    {
        $permintaanAtk->delete();
        return back()->with('success', 'Data permintaan dihapus.');
    }
}
