<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Aset;
use Illuminate\Http\Request;
use App\Services\AssetAssessmentService;

class AssessmentController extends Controller
{
    protected $assessmentService;

    public function __construct(AssetAssessmentService $assessmentService)
    {
        $this->assessmentService = $assessmentService;
    }

  public function index(Request $request)
{
    $query = Assessment::with('aset')->latest();

    // Filter berdasarkan nama aset (cari)
    if ($request->filled('aset_name')) {
        $query->whereHas('aset', function ($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->aset_name . '%');
        });
    }

    $assessments = $query->paginate(10)->withQueryString();

    return view('assessments.index', compact('assessments'));
}


    // ➕ Form tambah penilaian
    public function create()
    {
        $asets = Aset::with(['kategori', 'lokasi'])->get();
        return view('assessments.create', compact('asets'));
    }

    // 💾 Simpan penilaian baru
    public function store(Request $request)
    {
        $request->validate([
            'aset_id' => 'required|exists:asets,id',
            'condition' => 'required|string|in:baru,baik,rusak_ringan,rusak_berat',
            'notes' => 'nullable|string',
        ]);

        $aset = Aset::findOrFail($request->aset_id);

        // Hitung skor & status dari service
        $result = $this->assessmentService->assess($aset);
        $score = $result['skor'];
        $status = $result['status'];

        // Simpan ke database
        Assessment::create([
            'aset_id' => $request->aset_id,
            'condition' => $request->condition,
            'notes' => $request->notes,
            'score' => $score,
            'status' => $status,
        ]);

        return redirect()->route('assessments.index')
            ->with('success', 'Penilaian aset berhasil ditambahkan.');
    }

    // 🔍 Detail penilaian
    public function show(Assessment $assessment)
    {
        $assessment->load('aset');
        return view('assessments.show', compact('assessment'));
    }

     public function edit(Assessment $assessment)
    {
        // Ambil semua aset dengan relasi kategori & lokasi
        $asets = Aset::with(['kategori', 'lokasi'])->get();

        return view('assessments.edit', compact('assessment', 'asets'));
    }

    // 🔄 Update penilaian
    public function update(Request $request, Assessment $assessment)
    {
        $request->validate([
            'aset_id'   => 'required|exists:asets,id',
            'condition' => 'required|string|in:baru,baik,rusak_ringan,rusak_berat',
            'notes'     => 'nullable|string',
        ]);

        // Ambil data aset untuk proses assessment (jika ada service)
        $aset = Aset::findOrFail($request->aset_id);
        $result = $this->assessmentService->assess($aset);

        $assessment->update([
            'aset_id'   => $request->aset_id,
            'condition' => $request->condition,
            'notes'     => $request->notes,
            'score'     => $result['skor'],
            'status'    => $result['status'],
        ]);

        return redirect()->route('assessments.index')
            ->with('success', '✅ Penilaian aset berhasil diperbarui.');
    }
    // ❌ Hapus penilaian
    public function destroy(Assessment $assessment)
    {
        $assessment->delete();
        return redirect()->route('assessments.index')
            ->with('success', 'Penilaian aset berhasil dihapus.');
    }
}
