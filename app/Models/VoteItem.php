<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoteItem extends Model
{
    protected $fillable = [
        'nama_item',
        'deskripsi',
        'gambar',
        'harga',
        'aktif_hingga',
        'kelas_id',
        'periode_id',
        'dibuat_oleh',
        'status',
        'disetujui_pada',
        'disetujui_oleh',
    ];

    protected $casts = [
        'aktif_hingga' => 'date',
        'disetujui_pada' => 'datetime',
    ];

    public function kelas() {
        return $this->belongsTo(Kelas::class);
    }

    public function periode() {
        return $this->belongsTo(Periode::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }
}
