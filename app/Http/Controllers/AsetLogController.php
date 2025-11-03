<?php

namespace App\Http\Controllers;

use App\Models\AsetLog;
use App\Models\Aset;
use App\Models\Assessment;
use App\Models\Kategori;
use App\Models\Lokasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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
        'biaya' => $request->biaya,
        'tanggal_pengadaan' => $request->tanggal_pengadaan ?? now()->toDateString(),
        'created_by' => Auth::id(),
    ]);

    // 🔹 Inisialisasi counter untuk nomor inventaris per kategori per tahun
    $nomorCounters = [];

    foreach ($request->asets as $asetData) {
        if (empty($asetData['tanggal_perolehan'])) {
            $asetData['tanggal_perolehan'] = now()->toDateString();
        }

        $kategori = Kategori::find($asetData['kategori_id']);
        $year = Carbon::parse($asetData['tanggal_perolehan'])->year;
        $kategoriKey = $kategori->id . '-' . $year;

        if (!isset($nomorCounters[$kategoriKey])) {
            $lastAset = Aset::where('kategori_id', $kategori->id)
                ->whereYear('tanggal_perolehan', $year)
                ->orderBy('id', 'desc')
                ->first();

            $lastNumber = 0;
            if ($lastAset && preg_match('/(\d{4,})$/', $lastAset->nomor_inventaris, $matches)) {
                $lastNumber = (int) $matches[1];
            }

            $nomorCounters[$kategoriKey] = $lastNumber;
        }

        $nomorCounters[$kategoriKey]++;
        $seq = str_pad($nomorCounters[$kategoriKey], 4, '0', STR_PAD_LEFT);



        $asetData['nomor_inventaris'] = 'INV-' . strtoupper(substr($kategori->nama, 0, 3)) . "/{$year}/{$seq}";

        $asetData['aset_log_id'] = $asetLog->id;
        $asetData['created_by'] = Auth::id();

        $tanggalPerolehan = Carbon::parse($asetData['tanggal_perolehan']);
        $umurBulan = $tanggalPerolehan->diffInMonths(now());
        $asetData['umur_ekonomis'] = $umurBulan;

        $aset = Aset::create($asetData);

        Assessment::create([
            'aset_id'     => $aset->id,
            'condition'   => $aset->kondisi ?? 'baru',
            'usia_bulan'  => $aset->umur_ekonomis,
            'perbaikan'   => 0,
            'score'       => 100,
            'status'      => 'Layak',
        ]);
    }

    return redirect()->route('aset_logs.index')
        ->with('success', 'Pengadaan, aset, dan assessment berhasil dibuat dengan umur ekonomis otomatis.');
}

    public function show(AsetLog $asetLog)
    {
        $asetLog->load('asets.kategori', 'asets.lokasi');
        return view('aset_logs.show', compact('asetLog'));
    }

    public function print($id)
    {
        $asetLog = AsetLog::with(['asets.kategori', 'asets.lokasi'])->findOrFail($id);

        $pdf = Pdf::loadView('aset_logs.print', compact('asetLog'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('Detail_Pengadaan_Aset_' . $asetLog->nama_barang . '.pdf');
    }

    
}
