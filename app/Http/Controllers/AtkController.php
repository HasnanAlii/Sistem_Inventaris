<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\AtkLog;
use App\Models\AtkProcurement;
use App\Models\PermintaanAtk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtkController extends Controller
{
   public function index(Request $request)
{
    $stokMenipis = Atk::whereColumn('stok', '<=', 'stok_minimum')->count();

    $query = Atk::query();
    // if ($request->filled('kondisi')) {
    //     $query->where('kondisi', $request->kondisi);
    // }
    if ($request->filled('search')) {
        $query->where('nama_barang', 'like', '%' . $request->search . '%');
    }

    $atks = $query->orderBy('nama_barang')->paginate(10);
    return view('atks.index', compact('atks', 'stokMenipis'));
}


    public function create()
    {
        return view('atks.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'nama_barang' => 'required|string|max:255',
        'stok' => 'required|integer|min:0',
        'stok_minimum' => 'required|integer|min:0',
        'harga_satuan' => 'nullable|numeric|min:0',
        'tanggal_masuk' => 'nullable|date',
        'keterangan' => 'nullable|string',
    ]);

    // 1️⃣ Simpan ke tabel ATK
    $count = Atk::count() + 1;
    $atkData = $validated;
    $atkData['kode_barang'] = 'ATK-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    $atkData['created_by'] = Auth::id();

    $atk = Atk::create($atkData);

    // 2️⃣ Simpan ke tabel ATK Procurement
    AtkProcurement::create([
        'nama_barang' => $atk->nama_barang,
        'jumlah' => $validated['stok'],
        'tanggal_pengadaan' => $validated['tanggal_masuk'] ?? now(),
    ]);

    return redirect()->route('atks.index')->with('success', 'Barang ATK berhasil ditambahkan dan pengadaan dicatat.');
}


    public function show(Atk $atk)
    {
        return view('atks.show', compact('atk'));
    }

    public function edit(Atk $atk)
    {
        return view('atks.edit', compact('atk'));
    }

    public function update(Request $request, Atk $atk)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            // 'harga_satuan' => 'nullable|numeric|min:0',
            'kondisi' => 'required|in:baik,rusak',
            'tanggal_masuk' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $atk->update($validated);

        return redirect()->route('atks.index')->with('success', 'Data ATK berhasil diperbarui.');
    }

    public function destroy(Atk $atk)
    {
        $atk->delete();
        return redirect()->route('atks.index')->with('success', 'Data ATK berhasil dihapus.');
    }

    
        public function requestForm()
        {
            $atks = \App\Models\Atk::where('stok', '>', 0)->get();

            return view('atks.take', compact('atks'));
        }

        public function storeRequest(Request $request)
        {
            $validated = $request->validate([
                'atk_id' => 'required|exists:atks,id',
                'jumlah' => 'required|integer|min:1',
                'keterangan' => 'nullable|string|max:255',
            ]);

            $atk = \App\Models\Atk::findOrFail($validated['atk_id']);

            if ($validated['jumlah'] > $atk->stok) {
                return back()->withErrors(['jumlah' => 'Jumlah melebihi stok yang tersedia.'])->withInput();
            }

            \App\Models\AtkLog::create([
                'atk_id' => $atk->id,
                'user_id' => auth::id(),
                'jumlah' => $validated['jumlah'],
                'status' => 'Menunggu Konfirmasi',
            ]);

            return redirect()->route('logs.list')->with('success', 'Permintaan ATK berhasil dikirim!');
        }


}
