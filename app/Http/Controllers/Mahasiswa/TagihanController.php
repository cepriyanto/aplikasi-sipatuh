<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return view('dashboard.mahasiswa.tagihan', [
                'tagihans' => collect(),
                'totalTagihan' => 0,
                'totalLunas' => 0,
                'totalCicilan' => 0,
                'totalBelumLunas' => 0,
            ]);
        }

        $query = $mahasiswa->tagihans()->with('pembayarans');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('jenis', 'like', "%{$search}%")
                    ->orWhere('semester', 'like', "%{$search}%")
                    ->orWhere('jumlah', 'like', "%{$search}%");
            });
        }

        $tagihans = $query->orderBy('tanggal_jatuh_tempo', 'desc')->paginate(10)->withQueryString();

        $totalTagihan = $mahasiswa->tagihans()->sum('jumlah');
        $totalLunas = $mahasiswa->tagihans()->where('status', 'lunas')->sum('jumlah');
        $totalCicilan = $mahasiswa->tagihans()->where('status', 'cicilan')->sum('jumlah');
        $totalBelumLunas = $mahasiswa->tagihans()->where('status', 'belum_lunas')->sum('jumlah');

        return view('dashboard.mahasiswa.tagihan', compact(
            'tagihans',
            'totalTagihan',
            'totalLunas',
            'totalCicilan',
            'totalBelumLunas'
        ));
    }
}
