<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;

    protected $table = 'gejala';

    protected $fillable = [
        'kode_gejala',
        'nama_gejala',
        'jenis_gejala',
        'cf_pakar',
    ];

    public function aturan()
    {
        return $this->hasMany(Aturan::class, 'gejala_id');
    }

    public function detailDiagnosa()
    {
        return $this->hasMany(DetailDiagnosa::class, 'gejala_id');
    }
}
