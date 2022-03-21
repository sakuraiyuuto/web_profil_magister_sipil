<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenunjangSingkat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama_foto',
        'teks',
    ];
}
