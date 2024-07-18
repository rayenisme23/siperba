<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahanbaku extends Model
{
    use HasFactory;

    protected $table = 'bahanbaku';

    protected $fillable = ['nama_bahanbaku', 'harga', 'satuan', 'stok', 'tgl_exp', 'foto_bahanbaku'];
}
