<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceLog;
use App\Models\Aset;
use Illuminate\Http\Request;

class MaintenanceLogController extends Controller
{
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
            'aset_id' => 'required|exists:asets,id',
            'tanggal' => 'required|date',
            'jenis_perbaikan' => 'nullable|string|max:255',
            'biaya' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);

        MaintenanceLog::create($request->all());
        return redirect()->route('maintenance.index')->with('success', 'Data perbaikan berhasil ditambahkan.');
    }

    public function show(MaintenanceLog $maintenanceLog)
    {
        return view('maintenance_logs.show', compact('maintenanceLog'));
    }

    public function edit(MaintenanceLog $maintenanceLog)
    {
        $asets = Aset::orderBy('nama')->get();
        return view('maintenance_logs.edit', compact('maintenanceLog', 'asets'));
    }

    public function update(Request $request, MaintenanceLog $maintenanceLog)
    {
        $request->validate([
            'aset_id' => 'required|exists:asets,id',
            'tanggal' => 'required|date',
            'jenis_perbaikan' => 'nullable|string|max:255',
            'biaya' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $maintenanceLog->update($request->all());
        return redirect()->route('maintenance.index')->with('success', 'Data perbaikan berhasil diperbarui.');
    }

    public function destroy(MaintenanceLog $maintenanceLog)
    {
        $maintenanceLog->delete();
        return redirect()->route('maintenance.index')->with('success', 'Data perbaikan berhasil dihapus.');
    }

    // 🔹 Tambahan: Menampilkan log berdasarkan aset
    public function byAset(Aset $aset)
    {
        $logs = $aset->maintenanceLogs()->latest()->paginate(10);
        return view('maintenance_logs.by_aset', compact('aset', 'logs'));
    }
}
