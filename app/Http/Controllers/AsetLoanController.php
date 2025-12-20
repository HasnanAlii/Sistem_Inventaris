<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\AsetLoan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AsetLoanController extends Controller
{
    public function index()
    {
        $query = AsetLoan::with('aset', 'user');

        if (!Auth::user()->hasRole('petugas')) {
            $query->where('user_id', Auth::id());
        }

        $loans = $query->orderByRaw("FIELD(status, 'Menunggu Konfirmasi') DESC")
                    ->latest()
                    ->paginate(10);

        return view('aset_loans.index', compact('loans'));
    }


    public function create()
    {
        $asets = Aset::all();
        return view('aset_loans.create', compact('asets'));
    }

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
            'tanggal_harus' => Carbon::parse($request->tanggal_pinjam)->addDays(5),
            'status' => 'Menunggu Konfirmasi',
        ]);

        return redirect()->route('aset_loans.index')
                        ->with('success', 'Peminjaman aset berhasil diajukan. Menunggu konfirmasi.');
    }


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

        if ($request->status === 'Disetujui') {
            $asetLoan->aset->update(['status' => 'dipinjam']);
        } elseif ($request->status === 'Ditolak') {
            $asetLoan->aset->update(['status' => 'aktif']);
        } else {
            $asetLoan->aset->update(['status' => 'aktif']);
        }

        return redirect()
            ->route('aset_loans.index')
            ->with('success', 'Status peminjaman dan status aset berhasil diperbarui.');
    }

    public function return(Request $request, AsetLoan $asetLoan)
    {
        if (auth()->id() !== $asetLoan->user_id) {
            return back()->with('error', 'Anda tidak memiliki izin mengembalikan aset ini.');
        }

        $validated = $request->validate([
            'bukti' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:12048'], 
        ]);

        if ($asetLoan->bukti && Storage::disk('public')->exists($asetLoan->bukti)) {
            Storage::disk('public')->delete($asetLoan->bukti);
        }

        $path = $request->file('bukti')->store('bukti_pengembalian', 'public');

        $asetLoan->update([
            'status'          => 'Dikembalikan',
            'tanggal_kembali' => now(),
            'bukti'           => $path,
        ]);

        $asetLoan->aset->update([
            'status' => 'aktif', 
            'kondisi' => $asetLoan->aset->kondisi 
        ]);

        return back()->with('success', 'Aset berhasil dikembalikan dengan bukti foto dan status aset diperbarui.');
    }



}
