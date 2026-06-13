<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    protected $fillable = ['guru_id', 'penilai_id', 'periode', 'catatan'];

    public function penilai()
    {
        return $this->belongsTo(User::class, 'penilai_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function details()
    {
        return $this->hasMany(EvaluasiDetail::class);
    }
}
