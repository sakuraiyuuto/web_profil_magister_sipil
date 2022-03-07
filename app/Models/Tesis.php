<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tesis extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tesiss';

    protected $fillable = [
        'teks',
        'nama_file',
    ];
}
