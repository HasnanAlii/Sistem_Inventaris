<?php

namespace App\Http\Controllers;

use App\Models\AsetLog;
use App\Models\Aset;
use App\Models\Assessment;
use App\Models\Kategori;
use App\Models\Lokasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

    DB::transaction(function () use ($request) {

        /* =========================
           SIMPAN LOG PENGADAAN
        ========================= */
        $asetLog = AsetLog::create([
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'biaya' => $request->biaya,
            'tanggal_pengadaan' => $request->tanggal_pengadaan ?? now()->toDateString(),
            'created_by' => Auth::id(),
        ]);

        // Counter per kategori + tahun (dalam 1 request)
        $nomorCounters = [];

        foreach ($request->asets as $asetData) {

            $tanggalPerolehan = !empty($asetData['tanggal_perolehan'])
                ? Carbon::parse($asetData['tanggal_perolehan'])
                : now();

            $year = $tanggalPerolehan->year;
            $kategoriId = $asetData['kategori_id'];
            $counterKey = "{$kategoriId}-{$year}";

            /* =========================================
               AMBIL NOMOR TERAKHIR (LOCKED & AMAN)
            ========================================= */
            if (!isset($nomorCounters[$counterKey])) {

                $lastNumber = Aset::where('kategori_id', $kategoriId)
                    ->whereYear('tanggal_perolehan', $year)
                    ->lockForUpdate() // 🔐 cegah duplikat paralel
                    ->selectRaw("MAX(CAST(SUBSTRING_INDEX(nomor_inventaris, '/', -1) AS UNSIGNED)) as max_seq")
                    ->value('max_seq') ?? 0;

                $nomorCounters[$counterKey] = $lastNumber;
            }

            // Increment aman
            $nomorCounters[$counterKey]++;
            $seq = str_pad($nomorCounters[$counterKey], 4, '0', STR_PAD_LEFT);

            $kategori = Kategori::find($kategoriId);
            $kodeKategori = strtoupper(substr($kategori->nama, 0, 3));

            $nomorInventaris = "INV-{$kodeKategori}/{$year}/{$seq}";

            /* =========================
               HITUNG UMUR EKONOMIS
            ========================= */
            $umurBulan = $tanggalPerolehan->diffInMonths(now());

            /* =========================
               SIMPAN ASET
            ========================= */
            $aset = Aset::create([
                'nama' => $asetData['nama'],
                'kategori_id' => $kategoriId,
                'lokasi_id' => $asetData['lokasi_id'],
                'harga' => $asetData['harga'],
                'tanggal_perolehan' => $tanggalPerolehan->toDateString(),
                'nomor_inventaris' => $nomorInventaris,
                'umur_ekonomis' => $umurBulan,
                'aset_log_id' => $asetLog->id,
                'created_by' => Auth::id(),
            ]);

            /* =========================
               SIMPAN ASSESSMENT
            ========================= */
            Assessment::create([
                'aset_id'     => $aset->id,
                'condition'   => 'baru',
                'usia_bulan'  => $umurBulan,
                'perbaikan'   => 0,
                'score'       => 100,
                'status'      => 'Layak',
            ]);
        }
    });

    return redirect()
        ->route('aset_logs.index')
        ->with('success', 'Pengadaan, aset, dan assessment berhasil dibuat tanpa duplikasi nomor inventaris.');
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
