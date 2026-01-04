<?php

namespace App\Http\Controllers;


use App\Models\Aset;
use App\Models\AsetLog;
use App\Models\Assessment;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Services\AssetAssessmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsetController extends Controller
    {
    public function index(Request $request)
    {
        $query = Aset::with(['kategori', 'lokasi']);

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('lokasi_id')) {
            $query->where('lokasi_id', $request->lokasi_id);
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $asets = $query->latest()->paginate(10)->withQueryString();

        $kategoris = Kategori::orderBy('nama')->get();
        $lokasis = Lokasi::orderBy('nama')->get();

        return view('asets.index', compact('asets', 'kategoris', 'lokasis'));
    }


    public function show(Aset $aset)
    {
    $aset->load(['kategori', 'lokasi', 'maintenanceLogs']);
    return view('asets.show', compact('aset'));
    }


    public function edit(Aset $aset)
    {
        $kategoris = Kategori::all();
        $lokasis = Lokasi::all();

        return view('asets.edit', compact('aset', 'kategoris', 'lokasis'));
    }
    public function destroy(Aset $aset)
    {
        try {
            // Hapus semua penilaian terkait
            $aset->assessments()->delete();

            $aset->maintenanceLogs()->delete();

            // Hapus aset
            $aset->delete();

            return redirect()->route('asets.index')
                            ->with('success', 'Aset dan penilaian terkait berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('asets.index')
                            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Aset $aset, AssetAssessmentService $service)
    {
        $validated = $request->validate([
            'nama' => 'nullable|string|max:255',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'merek' => 'nullable|string',
            'tipe' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'tanggal_perolehan' => 'nullable|date',
            'harga' => 'nullable|numeric|min:0',
            'lokasi_id' => 'required|exists:lokasis,id',
            'kondisi' => 'required|in:baru,baik,rusak_ringan,rusak_berat',
        ]);

        if (!empty($validated['tanggal_perolehan'])) {
            $tanggalPerolehan = Carbon::parse($validated['tanggal_perolehan']);
            $umurBulan = $tanggalPerolehan->diffInMonths(now());
            $validated['umur_ekonomis'] = $umurBulan;
        }

        $validated['updated_by'] = Auth::id();

        // 🔹 Update aset
        $aset->update($validated);

        // 🔹 Hitung assessment otomatis
        $result = $service->assess($aset);

        // 🔹 Perbarui assessment terakhir atau buat baru
        $latestAssessment = $aset->assessments()->latest()->first();

        if ($latestAssessment) {
            $latestAssessment->update([
                'condition' => $aset->kondisi ?? 'baru',
                'score' => $result['skor'],
                'status' => $result['status'],
                'perbaikan' => $result['jumlah_perbaikan'],
            ]);
        
        }

        return redirect()->route('asets.index')
            ->with('success', 'Aset berhasil diperbarui dan penilaian otomatis telah dibuat.');
    }

    public function printLabel($id)
    {
        $aset = Aset::findOrFail($id);

        return view('asets.label', compact('aset'));
    }
}


