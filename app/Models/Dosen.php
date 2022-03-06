<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dosen extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'foto',
        'nama',
        'nip',
        'pangkat_golongan',
        'sinta',
        'url',
        'kelompok_keahlian_dosen_id'
    ];

    public function kelompokKeahlianDosen()
    {
        return $this->belongsTo(KelompokKeahlianDosen::class);
    }
}
