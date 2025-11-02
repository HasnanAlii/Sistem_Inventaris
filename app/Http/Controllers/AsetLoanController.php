<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\AsetLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsetLoanController extends Controller
{
    // 📝 Daftar peminjaman
    public function index()
    {
        $query = AsetLoan::with('aset', 'user');

        // Filter berdasarkan role
        if (!Auth::user()->hasRole('petugas')) {
            $query->where('user_id', Auth::id());
        }

        // Urutkan agar 'Menunggu Konfirmasi' muncul di atas
        $loans = $query->orderByRaw("FIELD(status, 'Menunggu Konfirmasi') DESC")
                    ->latest()
                    ->paginate(10);

        return view('aset_loans.index', compact('loans'));
    }


    // ➕ Form pengajuan peminjaman
    public function create()
    {
        $asets = Aset::all();
        return view('aset_loans.create', compact('asets'));
    }

    // 💾 Simpan pengajuan
    public function store(Request $request)
    {
        $request->validate([
            'aset_id' => 'required|exists:asets,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
        ]);

        AsetLoan::create([
            'aset_id' => $request->aset_id,
            'user_id' => Auth::id(),
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            // 'tanggal_kembali' => null,
            'status' => 'Menunggu Konfirmasi',
        ]);

        return redirect()->route('aset_loans.index')
                         ->with('success', 'Peminjaman aset berhasil diajukan. Menunggu konfirmasi.');
    }

    // 🔄 Edit peminjaman (hanya petugas/admin)
    public function edit(AsetLoan $asetLoan)
    {
            return view('aset_loans.edit', compact('asetLoan'));

    }

    public function editStatus(AsetLoan $asetLoan)
        {
            return view('aset_loans.edit', compact('asetLoan'));
        }

    public function updateStatus(Request $request, AsetLoan $asetLoan)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Konfirmasi,Disetujui,Ditolak',
        ]);

        $asetLoan->update(['status' => $request->status]);

        return redirect()->route('aset_loans.index')->with('success', 'Status peminjaman berhasil diperbarui.');
    }

    public function return(AsetLoan $asetLoan)
    {
        // Hanya peminjam sendiri yang bisa mengembalikan
        if(auth()->id() !== $asetLoan->user_id){
            return back()->with('error', 'Anda tidak memiliki izin mengembalikan aset ini.');
        }

        // Update status
        $asetLoan->update([
            'status' => 'Dikembalikan',
            'tanggal_kembali' => now(),
        ]);

        return back()->with('success', 'Aset berhasil dikembalikan.');
    }


}
