<?php

namespace App\Http\Controllers;

use App\Models\AsetLog;
use App\Models\Aset;
use App\Models\Assessment;
use App\Models\Kategori;
use App\Models\Lokasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsetLogController extends Controller
{
    // Tampilkan riwayat pengadaan
    public function index()
    {
        $logs = AsetLog::with('asets')->latest()->paginate(10);
        return view('aset_logs.index', compact('logs'));
    }

    // Form tambah pengadaan
    public function create()
    {
        $kategoris = Kategori::all();
        $lokasis = Lokasi::all();
        return view('aset_logs.create', compact('kategoris', 'lokasis'));
    }

    // Simpan pengadaan + banyak aset
public function store(Request $request)
{
    $request->validate([
        'nama_barang' => 'required|string|max:255',
        'jumlah' => 'required|integer|min:1',
        'biaya' => 'nullable|numeric|min:0',
        'tanggal_pengadaan' => 'nullable|date',

        'asets' => 'required|array|min:1',
        'asets.*.nama' => 'required|string|max:255',
        'asets.*.kategori_id' => 'required|exists:kategoris,id',
        'asets.*.harga' => 'required|numeric|min:0',
        'asets.*.tanggal_perolehan' => 'nullable|date',
        'asets.*.lokasi_id' => 'required|exists:lokasis,id',
    ]);

    // 🔹 Simpan pengadaan
    $asetLog = AsetLog::create([
        'nama_barang' => $request->nama_barang,
        'jumlah' => $request->jumlah,
        'biaya' => $request->biaya ?? 0,
        'tanggal_pengadaan' => $request->tanggal_pengadaan ?? now()->toDateString(),
        'created_by' => Auth::id(),
    ]);

    // 🔹 Simpan aset terkait dan buat Assessment otomatis
    foreach ($request->asets as $asetData) {
        // Jika tanggal perolehan kosong, gunakan hari ini
        if (empty($asetData['tanggal_perolehan'])) {
            $asetData['tanggal_perolehan'] = now()->toDateString();
        }

        // Generate nomor inventaris otomatis
        $kategori = Kategori::find($asetData['kategori_id']);
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
        $asetData['nomor_inventaris'] = 'INV-' . strtoupper(substr($kategori->nama, 0, 3)) . "/{$year}/{$seq}";

        // Hubungkan dengan pengadaan
        $asetData['aset_log_id'] = $asetLog->id;
        $asetData['created_by'] = Auth::id();

        // Simpan aset
        $aset = Aset::create($asetData);

        // 🔹 Buat Assessment otomatis untuk aset ini
        Assessment::create([
            'aset_id' => $aset->id,
            'condition' => $aset->kondisi ?? 'baru', // default 'baru' jika belum ada
            'notes' => 'Penilaian awal otomatis',
            'score' => 100,
            'status' => 'Layak',
        ]);
    }

    return redirect()->route('aset_logs.index')->with('success', 'Pengadaan, aset, dan assessment berhasil dibuat.');
}
    public function show(AsetLog $asetLog)
    {
        // Load aset terkait dengan kategori dan lokasi
        $asetLog->load('asets.kategori', 'asets.lokasi');

        return view('aset_logs.show', compact('asetLog'));
    }

    public function print($id)
{
    $asetLog = AsetLog::with(['asets.kategori', 'asets.lokasi'])->findOrFail($id);

    $pdf = Pdf::loadView('aset_logs.print', compact('asetLog'))
              ->setPaper('a4', 'portrait');

    // return $pdf->download('Detail_Pengadaan_Aset_' . $asetLog->nama_barang . '.pdf');
    return $pdf->stream('Detail_Pengadaan_Aset_' . $asetLog->nama_barang . '.pdf');



    
}



}
