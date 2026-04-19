<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = ['user_id', 'nip', 'nama_lengkap', 'no_telp', 'foto'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evaluasis()
    {
        return $this->hasMany(Evaluasi::class);
    }
}
