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

    if ($request->filled('search')) {
        $query->where('nama_barang', 'like', '%' . $request->search . '%');
    }

    $atks = $query->orderBy('nama_barang')->paginate(10);
    return view('atks.index', compact('atks', 'stokMenipis'));
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
            'nama_barang' => 'nullable|string|max:255',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'harga_satuan' => 'nullable|numeric|min:0',
            'tanggal_masuk' => 'nullable|date',
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
            ]);

            $atk = \App\Models\Atk::findOrFail($validated['atk_id']);

            if ($validated['jumlah'] > $atk->stok) {
                return back()->withErrors(['jumlah' => 'Jumlah melebihi stok yang tersedia.'])->withInput();
            }

            AtkLog::create([
                'atk_id' => $atk->id,
                'user_id' => auth::id(),
                'jumlah' => $validated['jumlah'],
                'status' => 'Menunggu Konfirmasi',
            ]);

            return redirect()->route('logs.list')->with('success', 'Permintaan ATK berhasil dikirim!');
        }


}
