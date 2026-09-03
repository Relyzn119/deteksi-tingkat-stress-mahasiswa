<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;

    protected $table = 'penyakit';

    protected $fillable = [
        'kode_penyakit',
        'nama_penyakit',
        'deskripsi',
        'solusi',
    ];

    public function aturan()
    {
        return $this->hasMany(Aturan::class, 'penyakit_id');
    }
}
