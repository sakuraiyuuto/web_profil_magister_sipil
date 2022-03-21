<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penunjang extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'penunjangs';

    protected $fillable = [
        'nama',
        'thumbnail',
        'teks',
        'release_date',
        'slug'
    ];
}
