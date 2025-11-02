<?php

namespace App\Http\Controllers;

use App\Models\Atk;
use App\Models\AtkProcurement;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        'nama_pengadaan' => 'required|string|max:255',
        'atk_items' => 'required|array|min:1',
        'atk_items.*.nama_barang' => 'required|string|max:255',
        'atk_items.*.stok' => 'required|integer|min:1',
        'atk_items.*.harga_satuan' => 'nullable|numeric|min:0',
        'atk_items.*.tanggal_masuk' => 'nullable|date',
        'atk_items.*.keterangan' => 'nullable|string|max:1000',
    ]);

    DB::transaction(function () use ($request) {
        // 🔹 Simpan pengadaan ATK
        $procurement = AtkProcurement::create([
            'nama_barang' => $request->nama_pengadaan,
            'jumlah' => array_sum(array_column($request->atk_items, 'stok')),
            'biaya' => array_sum(array_map(fn($item) => ($item['harga_satuan'] ?? 0) * $item['stok'], $request->atk_items)),
            'tanggal_pengadaan' => now()->toDateString(),
        ]);

        // 🔹 Simpan semua ATK terkait
        foreach ($request->atk_items as $item) {
            $lastId = Atk::max('id') ?? 0;
            $kodeBarang = 'ATK-' . ($lastId + 1);

            $hargaSatuan = $item['harga_satuan'] ?? 0;
            $stok = $item['stok'];

            Atk::create([
                'kode_barang' => $kodeBarang,
                'nama_barang' => $item['nama_barang'],
                'stok' => $stok,
                'stok_minimum' => $item['stok_minimum'] ?? 5,
                'harga_satuan' => $hargaSatuan,
                'total_harga' => $stok * $hargaSatuan, 
                'tanggal_masuk' => $item['tanggal_masuk'] ?? now()->toDateString(),
                'keterangan' => $item['keterangan'] ?? null,
                'created_by' => Auth::id(),
                'procurement_id' => $procurement->id,
            ]);
        }
    });

    return redirect()->route('logs.addatk')->with('success', 'Pengadaan dan ATK berhasil ditambahkan.');
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
    
    public function show(AtkProcurement $atkProcurement)
    {
        return view('atks.procurements.show', [
            'procurement' => $atkProcurement
        ]);
    }

    public function print(AtkProcurement $atkProcurement)
    {
   {
    $atkProcurement->load('atks'); // Load data ATK

    $pdf = Pdf::loadView('atks.procurements.pdf', [
        'procurement' => $atkProcurement
    ])->setPaper('a4', 'portrait'); // ukuran kertas A4

    // Bisa langsung download
    return $pdf->download('Laporan_Pengadaan_ATK_'.$atkProcurement->id.'.pdf');

    
}
    }

}
