<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceLog;
use App\Models\Aset;
use App\Services\AssetAssessmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MaintenanceLogController extends Controller
{
    protected $assessmentService;

    public function __construct(AssetAssessmentService $assessmentService)
    {
        $this->assessmentService = $assessmentService;
    }

    public function index()
    {
        $logs = MaintenanceLog::with('aset')->latest()->paginate(10);
        return view('maintenance_logs.index', compact('logs'));
    }

    public function create()
    {
        $asets = Aset::orderBy('nama')->get();
        return view('maintenance_logs.create', compact('asets'));
    }

 public function store(Request $request)
{
    $request->validate([
        'aset_id'         => 'required|exists:asets,id',
        'tanggal'         => 'required|date',
        'jenis_perbaikan' => 'nullable|string|max:255',
        'biaya'           => 'nullable|numeric', 
    ]);

    $maintenance = MaintenanceLog::create([
        'aset_id'         => $request->aset_id,
        'tanggal'         => $request->tanggal,
        'jenis_perbaikan' => $request->jenis_perbaikan,
        'biaya'           => $request->biaya, 
    ]);

    $aset = Aset::findOrFail($request->aset_id);

    $aset->update([
        'kondisi' => 'baik'
    ]);

    $result = $this->assessmentService->assess($aset);

    $latestAssessment = $aset->assessments()->latest()->first();

    if ($latestAssessment) {
        $latestAssessment->update([
            'score'       => $result['skor'],
            'status'      => $result['status'],
            'usia_bulan'  => $aset->umur_ekonomis,
            'perbaikan'   => $aset->maintenanceLogs()->count(),
            'condition'   => 'baik',
        ]);
    } else {
        $aset->assessments()->create([
            'score'       => $result['skor'],
            'status'      => $result['status'],
            'condition'   => 'baik',
            'usia_bulan'  => $aset->umur_ekonomis,
            'perbaikan'   => $aset->maintenanceLogs()->count(),
        ]);
    }

    return redirect()->route('maintenance.index')
        ->with('success', '✅ Data perbaikan berhasil ditambahkan dan kondisi aset diperbarui menjadi "baik".');
}


    public function show(MaintenanceLog $maintenanceLog)
    {
        return view('maintenance_logs.show', compact('maintenanceLog'));
    }


    public function destroy(MaintenanceLog $maintenanceLog)
    {
        $aset = $maintenanceLog->aset;
        $maintenanceLog->delete();

        // 🔹 Update assessment otomatis setelah penghapusan log
        if ($aset) {
            $aset->umur_ekonomis = $aset->tanggal_perolehan->diffInMonths(now());
            $aset->save();

            $result = $this->assessmentService->assess($aset);
            $latestAssessment = $aset->assessments()->latest()->first();
            if ($latestAssessment) {
                $latestAssessment->update([
                    'score'       => $result['skor'],
                    'status'      => $result['status'],
                    'usia_bulan'  => $aset->umur_ekonomis,
                    'perbaikan'   => $aset->maintenanceLogs()->count(),
                ]);
            }
        }

        return redirect()->route('maintenance.index')
            ->with('success', 'Data perbaikan berhasil dihapus dan penilaian aset diperbarui.');
    }

  
}
