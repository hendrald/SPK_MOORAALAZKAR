<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluasiDetail extends Model
{
    protected $fillable = ['evaluasi_id', 'kriteria_id', 'nilai'];

    public function evaluasi()
    {
        return $this->belongsTo(Evaluasi::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}
