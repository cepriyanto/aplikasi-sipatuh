<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'tagihan_id',
        'tanggal_bayar',
        'jumlah_bayar',
        'metode',
        'bukti_pembayaran',
        'status_verifikasi',
        'verified_by',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'jumlah_bayar' => 'decimal:2',
    ];

    /**
     * Status verifikasi constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_DITERIMA = 'diterima';
    const STATUS_DITOLAK = 'ditolak';

    /**
     * Metode pembayaran constants
     */
    const METODE_TRANSFER_BANK = 'transfer_bank';
    const METODE_E_WALLET = 'e_wallet';
    const METODE_CASH = 'cash';

    /**
     * Get the tagihan that owns the pembayaran.
     */
    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class);
    }

    /**
     * Get the user that verified the pembayaran.
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get the riwayat transaksi for the pembayaran.
     */
    public function riwayatTransaksi(): HasOne
    {
        return $this->hasOne(RiwayatTransaksi::class);
    }

    /**
     * Get the payment gateway for the pembayaran.
     */
    public function paymentGateway(): HasOne
    {
        return $this->hasOne(PaymentGateway::class);
    }

    /**
     * Scope untuk pembayaran pending
     */
    public function scopePending($query)
    {
        return $query->where('status_verifikasi', self::STATUS_PENDING);
    }

    /**
     * Scope untuk pembayaran diterima
     */
    public function scopeDiterima($query)
    {
        return $query->where('status_verifikasi', self::STATUS_DITERIMA);
    }

    /**
     * Scope untuk pembayaran ditolak
     */
    public function scopeDitolak($query)
    {
        return $query->where('status_verifikasi', self::STATUS_DITOLAK);
    }
}