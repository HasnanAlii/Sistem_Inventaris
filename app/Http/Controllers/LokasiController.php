<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasis = Lokasi::latest()->paginate(10);
        return view('lokasis.index', compact('lokasis'));
    }

    public function create()
    {
        return view('lokasis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|unique:lokasis,nama|max:255',
            
            'keterangan' => 'nullable|string',
        ]);

        Lokasi::create($validated);

        return redirect()->route('lokasis.index')->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function edit(Lokasi $lokasi)
    {
        return view('lokasis.edit', compact('lokasi'));
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255|unique:lokasis,nama,' . $lokasi->id,
          
            'keterangan' => 'nullable|string',
        ]);

        $lokasi->update($validated);

        return redirect()->route('lokasis.index')->with('success', 'Lokasi berhasil diperbarui.');
    }

    public function destroy(Lokasi $lokasi)
    {
        $lokasi->delete();
        return redirect()->route('lokasis.index')->with('success', 'Lokasi berhasil dihapus.');
    }
}
