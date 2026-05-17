<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'pembayaran_id',
        'keterangan',
    ];

    /**
     * Get the mahasiswa that owns the riwayat transaksi.
     */
    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    /**
     * Get the pembayaran that owns the riwayat transaksi.
     */
    public function pembayaran(): BelongsTo
    {
        return $this->belongsTo(Pembayaran::class);
    }
}