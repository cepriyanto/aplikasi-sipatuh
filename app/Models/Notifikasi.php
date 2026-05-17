<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tagihan_id',
        'judul',
        'pesan',
        'status',
        'type',
    ];

    /**
     * Status constants
     */
    const STATUS_DIBACA = 'dibaca';
    const STATUS_BELUM = 'belum';

    /**
     * Type constants
     */
    const TYPE_WARNING = 'warning';
    const TYPE_DANGER = 'danger';
    const TYPE_SUCCESS = 'success';

    /**
     * Get the user that owns the notifikasi.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tagihan that belongs to the notifikasi.
     */
    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class);
    }

    /**
     * Scope untuk notifikasi belum dibaca
     */
    public function scopeBelumDibaca($query)
    {
        return $query->where('status', self::STATUS_BELUM);
    }
}