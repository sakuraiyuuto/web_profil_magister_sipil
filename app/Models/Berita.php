<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'judul',
        'thumbnail',
        'teks',
        'slug',
        'release_date'
    ];
}
