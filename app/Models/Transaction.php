<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'kelas_id', 'periode_id', 'tipe', 'jumlah', 'keterangan', 'tanggal'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function kelas() {
        return $this->belongsTo(Kelas::class);
    }

    public function periode() {
        return $this->belongsTo(Periode::class);
    }
}
