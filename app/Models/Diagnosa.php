<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
    use HasFactory;

    protected $table = 'diagnosa';

    protected $fillable = [
        'user_id',
        'jumlah_utama',
        'jumlah_tambahan',
        'hasil_cf',
        'persentase',
        'hasil_diagnosa',
        'tanggal',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'datetime',
            'hasil_cf' => 'float',
            'persentase' => 'float',
            'jumlah_utama' => 'integer',
            'jumlah_tambahan' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detailDiagnosa()
    {
        return $this->hasMany(DetailDiagnosa::class, 'diagnosa_id');
    }
}
