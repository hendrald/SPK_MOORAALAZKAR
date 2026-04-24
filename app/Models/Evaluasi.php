<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    protected $fillable = ['guru_id', 'periode', 'catatan'];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function details()
    {
        return $this->hasMany(EvaluasiDetail::class);
    }
}
