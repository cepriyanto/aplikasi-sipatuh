<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nim',
        'nama',
        'jurusan',
        'angkatan',
    ];

    /**
     * Get the user that owns the mahasiswa.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tagihans for the mahasiswa.
     */
    public function tagihans(): HasMany
    {
        return $this->hasMany(Tagihan::class);
    }

    /**
     * Get the riwayat transaksis for the mahasiswa.
     */
    public function riwayatTransaksis(): HasMany
    {
        return $this->hasMany(RiwayatTransaksi::class);
    }

    /**
     * Get total tagihan mahasiswa
     */
    public function getTotalTagihanAttribute(): float
    {
        return $this->tagihans()->sum('jumlah');
    }

    /**
     * Get total pembayaran mahasiswa
     */
    public function getTotalBayarAttribute(): float
    {
        return $this->tagihans()
            ->with('pembayarans')
            ->get()
            ->sum(function ($tagihan) {
                return $tagihan->pembayarans()
                    ->where('status_verifikasi', 'diterima')
                    ->sum('jumlah_bayar');
            });
    }

    /**
     * Get sisa tagihan
     */
    public function getSisaTagihanAttribute(): float
    {
        return $this->total_tagihan - $this->total_bayar;
    }
}