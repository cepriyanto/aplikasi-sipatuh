<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifikasis = $user->notifikasis()->orderBy('created_at', 'desc')->paginate(10);
        $unreadCount = $user->notifikasis()->belumDibaca()->count();

        return view('dashboard.mahasiswa.notifikasi', compact('notifikasis', 'unreadCount'));
    }

    public function markAsRead(Notifikasi $notifikasi)
    {
        if ($notifikasi->user_id !== Auth::id()) {
            abort(403);
        }

        $notifikasi->update(['status' => 'dibaca']);

        return back()->with('success', 'Notifikasi berhasil ditandai sebagai dibaca.');
    }

    public function markAllRead()
    {
        $user = Auth::user();
        $user->notifikasis()->belumDibaca()->update(['status' => 'dibaca']);

        return back()->with('success', 'Semua notifikasi berhasil ditandai sebagai dibaca.');
    }
}
