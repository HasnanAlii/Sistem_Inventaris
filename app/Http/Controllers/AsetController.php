<?php

namespace App\Http\Controllers;


use App\Models\Aset;
use App\Models\AsetLog;
use App\Models\Assessment;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Services\AssetAssessmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsetController extends Controller
{
public function index(Request $request)
{
    $query = Aset::with(['kategori', 'lokasi']);

    // Filter pencarian
    if ($request->filled('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    // Filter kategori
    if ($request->filled('kategori_id')) {
        $query->where('kategori_id', $request->kategori_id);
    }

    // Filter lokasi
    if ($request->filled('lokasi_id')) {
        $query->where('lokasi_id', $request->lokasi_id);
    }

    // Filter kondisi
    if ($request->filled('kondisi')) {
        $query->where('kondisi', $request->kondisi);
    }

    $asets = $query->latest()->paginate(10)->withQueryString();

    $kategoris = Kategori::orderBy('nama')->get();
    $lokasis = Lokasi::orderBy('nama')->get();

    return view('asets.index', compact('asets', 'kategoris', 'lokasis'));
}


public function create()
{
$kategoris = Kategori::all();
$lokasis = Lokasi::all();
return view('asets.create', compact('kategoris', 'lokasis'));
}

public function assess($id, AssetAssessmentService $service)
{
    $aset = Aset::with('maintenanceLogs')->findOrFail($id);
    $result = $service->assess($aset);

    return view('asets.assessment', compact('aset', 'result'));
}


public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'kategori_id' => 'required|exists:kategoris,id',
        'merek' => 'nullable|string',
        'tipe' => 'nullable|string',
        'serial_number' => 'nullable|string',
        'tanggal_perolehan' => 'required|date',
        'umur_ekonomis' => 'required|integer|min:1',
        'harga' => 'required|numeric|min:0',
        'lokasi_id' => 'required|exists:lokasis,id',
        'kondisi' => 'required|in:baru,baik,rusak_ringan,rusak_berat',
    ]);

    // 🔹 Generate Nomor Inventaris Otomatis
    $kategori = Kategori::find($request->kategori_id);
    $year = now()->year;

    $lastAset = Aset::where('kategori_id', $kategori->id)
        ->whereYear('tanggal_perolehan', $year)
        ->orderBy('id', 'desc')
        ->first();

    $lastNumber = 0;
    if ($lastAset && preg_match('/(\d{4})$/', $lastAset->nomor_inventaris, $matches)) {
        $lastNumber = (int) $matches[1];
    }

    $seq = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    $validated['nomor_inventaris'] = 'INV-' . strtoupper(substr($kategori->nama, 0, 3)) . "/{$year}/{$seq}";
    $validated['created_by'] = Auth::id();

    // 🔹 Simpan Aset
    $aset = Aset::create($validated);

    // 🔹 Simpan log penambahan
    AsetLog::create([
        'aset_id' => $aset->id,
        'type' => 'created',
        'keterangan' => "Aset '{$aset->nama}' ditambahkan oleh " . Auth::user()->name,
    ]);

    // 🔹 Buat Assessment otomatis
    Assessment::create([
        'aset_id' => $aset->id,
        'condition' => $aset->kondisi, // bisa ambil kondisi awal dari aset
        'notes' => 'Penilaian awal otomatis',
        'score' => 100, // atau sesuai logika default
        'status' => 'Layak', // default status
    ]);

    return redirect()->route('asets.index')->with('success', 'Aset berhasil ditambahkan dan assessment otomatis dibuat.');
}


public function show(Aset $aset)
{
$aset->load(['kategori', 'lokasi', 'maintenanceLogs']);
return view('asets.show', compact('aset'));
}


public function edit(Aset $aset)
{
    // Ambil semua kategori dan lokasi untuk dropdown
    $kategoris = Kategori::all();
    $lokasis = Lokasi::all();

    // Kirim data ke view edit
    return view('asets.edit', compact('aset', 'kategoris', 'lokasis'));
}
public function destroy(Aset $aset)
{
    try {
        // Hapus data aset
        $aset->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('asets.index')
                         ->with('success', 'Aset berhasil dihapus.');
    } catch (\Exception $e) {
        // Jika terjadi error, redirect dengan pesan error
        return redirect()->route('asets.index')
                         ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

}


