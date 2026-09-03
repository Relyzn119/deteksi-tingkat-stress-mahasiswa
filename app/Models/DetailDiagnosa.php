<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDiagnosa extends Model
{
    use HasFactory;

    protected $table = 'detail_diagnosa';

    protected $fillable = [
        'diagnosa_id',
        'gejala_id',
        'cf_user',
        'cf_hasil',
    ];

    protected function casts(): array
    {
        return [
            'cf_user' => 'float',
            'cf_hasil' => 'float',
        ];
    }

    public function diagnosa()
    {
        return $this->belongsTo(Diagnosa::class, 'diagnosa_id');
    }

    public function gejala()
    {
        return $this->belongsTo(Gejala::class, 'gejala_id');
    }
}
