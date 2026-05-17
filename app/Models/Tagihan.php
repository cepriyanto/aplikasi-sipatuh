<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tagihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'jenis',
        'semester',
        'jumlah',
        'tanggal_jatuh_tempo',
        'status',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal_jatuh_tempo' => 'date',
    ];

    /**
     * Status constants
     */
    const STATUS_BELUM_LUNAS = 'belum_lunas';
    const STATUS_LUNAS = 'lunas';
    const STATUS_CICILAN = 'cicilan';

    /**
     * Jenis tagihan constants
     */
    const JENIS_UKT = 'UKT';
    const JENIS_SPP = 'SPP';
    const JENIS_DENDA = 'DENDA';
    const JENIS_LAINNYA = 'LAINNYA';

    /**
     * Get the mahasiswa that owns the tagihan.
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    /**
     * Get the pembayarans for the tagihan.
     */
    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    /**
     * Get total pembayaran yang sudah diverifikasi
     */
    public function getTotalBayarAttribute(): float
    {
        return $this->pembayarans()
            ->where('status_verifikasi', 'diterima')
            ->sum('jumlah_bayar');
    }

    /**
     * Get sisa pembayaran
     */
    public function getSisaBayarAttribute(): float
    {
        return $this->jumlah - $this->total_bayar;
    }

    /**
     * Check if tagihan sudah lunas
     */
    public function getIsLunasAttribute(): bool
    {
        return $this->total_bayar >= $this->jumlah;
    }

    /**
     * Check if tagihan sudah jatuh tempo
     */
    public function getIsJatuhTempoAttribute(): bool
    {
        return now()->greaterThan($this->tanggal_jatuh_tempo);
    }
}