<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'aktif',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'aktif' => 'boolean',
    ];

    /**
     * Check if semester is active
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->aktif;
    }

    /**
     * Check if semester is current
     */
    public function getIsCurrentAttribute(): bool
    {
        $now = now()->toDateString();
        return $this->tanggal_mulai <= $now && $this->tanggal_selesai >= $now;
    }
}