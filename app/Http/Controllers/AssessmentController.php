<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Aset;
use Illuminate\Http\Request;
use App\Services\AssetAssessmentService;
use Barryvdh\DomPDF\Facade\Pdf;

class AssessmentController extends Controller
{
    protected $assessmentService;

    public function __construct(AssetAssessmentService $assessmentService)
    {
        $this->assessmentService = $assessmentService;
    }

    public function index(Request $request)
    {
        $query = Assessment::with('aset');

        if ($request->filled('aset_name')) {
            $query->whereHas('aset', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->aset_name . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $assessments = $query->latest()->paginate(10)->withQueryString();

        return view('assessments.index', compact('assessments'));
    }

    public function show(Assessment $assessment)
    {
        $assessment->load('aset');
        return view('assessments.show', compact('assessment'));
    }
    public function destroy(Assessment $assessment)
    {
        try {
            $aset = $assessment->aset;

            if ($aset) {
                $aset->assessments()->delete();

                if (method_exists($aset, 'maintenanceLogs')) {
                    $aset->maintenanceLogs()->delete();
                }

                $aset->delete();
            }

            return redirect()->route('assessments.index')
                ->with('success', 'Assessment, aset, dan perbaikan terkait berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('assessments.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function print()
    {
        $assessments = Assessment::with('aset')->get();

        $pdf = Pdf::loadView('assessments.pdf', compact('assessments'))
                ->setPaper('a4', 'portrait');

        return $pdf->stream('Daftar_Penilaian_Aset_' . date('Y-m-d') . '.pdf');
    }

}
