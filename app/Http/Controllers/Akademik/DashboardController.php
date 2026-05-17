<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Tagihan;
use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Display akademik dashboard
     */
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();
        
        $mahasiswaByJurusan = Mahasiswa::select('jurusan', DB::raw('count(*) as total'))
            ->groupBy('jurusan')
            ->get();

        $mahasiswaByAngkatan = Mahasiswa::select('angkatan', DB::raw('count(*) as total'))
            ->groupBy('angkatan')
            ->orderBy('angkatan', 'desc')
            ->get();

        // Get payment status summary
        $tagihanSummary = [
            'total' => Tagihan::count(),
            'lunas' => Tagihan::where('status', 'lunas')->count(),
            'cicilan' => Tagihan::where('status', 'cicilan')->count(),
            'belum_lunas' => Tagihan::where('status', 'belum_lunas')->count(),
        ];

        return view('dashboard.akademik.index', compact(
            'totalMahasiswa',
            'mahasiswaByJurusan',
            'mahasiswaByAngkatan',
            'tagihanSummary'
        ));
    }

    /**
     * Display mahasiswa management
     */
    public function mahasiswas(Request $request)
    {
        $query = Mahasiswa::with('user');

        // Filter by jurusan
        if ($request->has('jurusan') && $request->jurusan) {
            $query->where('jurusan', $request->jurusan);
        }

        // Filter by angkatan
        if ($request->has('angkatan') && $request->angkatan) {
            $query->where('angkatan', $request->angkatan);
        }

        // Filter by status pembayaran
        if ($request->has('status_pembayaran') && $request->status_pembayaran) {
            $query->whereHas('tagihans', function ($q) use ($request) {
                $q->where('status', $request->status_pembayaran);
            });
        }

        $mahasiswas = $query->orderBy('nama', 'asc')->paginate(20);

        // Get unique jurusan and angkatan for filters
        $jurusans = Mahasiswa::distinct()->pluck('jurusan');
        $angkatans = Mahasiswa::distinct()->pluck('angkatan')->sort()->reverse();

        return view('dashboard.akademik.mahasiswas', compact('mahasiswas', 'jurusans', 'angkatans'));
    }

    /**
     * Display tagihan management for akademik
     */
    public function tagihan(Request $request)
    {
        $query = Tagihan::with(['mahasiswa.user']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('jenis') && $request->jenis) {
            $query->where('jenis', $request->jenis);
        }

        $tagihans = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('dashboard.akademik.tagihan', compact('tagihans'));
    }

    /**
     * Show create mahasiswa form
     */
    public function createMahasiswa()
    {
        return view('dashboard.akademik.create-mahasiswa');
    }

    /**
     * Store new mahasiswa
     */
    public function storeMahasiswa(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nim' => 'required|string|unique:mahasiswas,nim|max:20',
            'nama' => 'required|string|max:100',
            'jurusan' => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:2100',
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);

        // Create mahasiswa profile
        $mahasiswa = Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => $request->nim,
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
            'angkatan' => $request->angkatan,
        ]);

        // Log aktivitas
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => 'create_mahasiswa',
            'deskripsi' => 'Membuat data mahasiswa baru: ' . $mahasiswa->nama . ' (NIM: ' . $mahasiswa->nim . ')',
            'tabel_terkait' => 'mahasiswas',
            'record_id' => $mahasiswa->id,
        ]);

        return redirect()->route('dashboard.akademik.mahasiswas')
            ->with('success', 'Data mahasiswa berhasil dibuat.');
    }

    /**
     * Show edit mahasiswa form
     */
    public function editMahasiswa(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load('user');
        return view('dashboard.akademik.edit-mahasiswa', compact('mahasiswa'));
    }

    /**
     * Update mahasiswa
     */
    public function updateMahasiswa(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $mahasiswa->user_id,
            'nim' => 'required|string|max:20|unique:mahasiswas,nim,' . $mahasiswa->id,
            'nama' => 'required|string|max:100',
            'jurusan' => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:2100',
        ]);

        DB::transaction(function () use ($request, $mahasiswa) {
            // Update user
            $mahasiswa->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Update password if provided
            if ($request->password) {
                $request->validate(['password' => 'string|min:8|confirmed']);
                $mahasiswa->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            // Update mahasiswa
            $mahasiswa->update([
                'nim' => $request->nim,
                'nama' => $request->nama,
                'jurusan' => $request->jurusan,
                'angkatan' => $request->angkatan,
            ]);
        });

        // Log aktivitas
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => 'update_mahasiswa',
            'deskripsi' => 'Mengupdate data mahasiswa: ' . $mahasiswa->nama . ' (NIM: ' . $mahasiswa->nim . ')',
            'tabel_terkait' => 'mahasiswas',
            'record_id' => $mahasiswa->id,
        ]);

        return redirect()->route('dashboard.akademik.mahasiswas')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Delete mahasiswa
     */
    public function destroyMahasiswa(Mahasiswa $mahasiswa)
    {
        $nama = $mahasiswa->nama;
        $nim = $mahasiswa->nim;

        // Delete user (will cascade to mahasiswa)
        $mahasiswa->user->delete();

        // Log aktivitas
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => 'delete_mahasiswa',
            'deskripsi' => 'Menghapus data mahasiswa: ' . $nama . ' (NIM: ' . $nim . ')',
            'tabel_terkait' => 'mahasiswas',
            'record_id' => $mahasiswa->id,
        ]);

        return redirect()->route('dashboard.akademik.mahasiswas')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    /**
     * Show mahasiswa detail with payment status
     */
    public function showMahasiswa(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load(['user', 'tagihans.pembayarans', 'riwayatTransaksis']);

        return view('dashboard.akademik.show-mahasiswa', compact('mahasiswa'));
    }

    /**
     * Create tagihan for mahasiswa
     */
    public function createTagihan(Mahasiswa $mahasiswa)
    {
        return view('dashboard.akademik.create-tagihan', compact('mahasiswa'));
    }

    /**
     * Store tagihan for mahasiswa
     */
    public function storeTagihan(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'jenis' => 'required|in:UKT,SPP,DENDA,LAINNYA',
            'semester' => 'required|string|max:10',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal_jatuh_tempo' => 'required|date',
        ]);

        $tagihan = Tagihan::create([
            'mahasiswa_id' => $mahasiswa->id,
            'jenis' => $request->jenis,
            'semester' => $request->semester,
            'jumlah' => $request->jumlah,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            'status' => 'belum_lunas',
        ]);
 
         // Generate due date notification for this specific tagihan
         app(\App\Services\NotifikasiJatuhTempoService::class)->cekDanBuatNotifikasi($tagihan);

        // Log aktivitas
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => 'create_tagihan',
            'deskripsi' => 'Membuat tagihan untuk mahasiswa: ' . $mahasiswa->nama . ' (NIM: ' . $mahasiswa->nim . ')',
            'tabel_terkait' => 'tagihans',
            'record_id' => $tagihan->id,
        ]);

        return redirect()->route('dashboard.akademik.show-mahasiswa', $mahasiswa->id)
             ->with('success', 'Tagihan berhasil dibuat untuk mahasiswa.');
    }

    /**
     * Send manual reminder for a tagihan
     */
    public function sendReminder(Tagihan $tagihan)
    {
        $sent = app(\App\Services\NotifikasiJatuhTempoService::class)->kirimPengingatManual($tagihan);

        if ($sent) {
            return back()->with('success', 'Notifikasi pengingat berhasil dikirim ke mahasiswa.');
        }

        return back()->with('error', 'Gagal mengirim notifikasi. Pastikan data mahasiswa valid.');
    }
}