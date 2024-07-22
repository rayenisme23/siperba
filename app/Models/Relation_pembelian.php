<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relation_pembelian extends Model
{
    use HasFactory;

    protected $table = 'relation_pembelian';

    protected $guarded = [];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id', 'id');
    }

    public function bahanBaku()
    {
        return $this->belongsTo(Bahanbaku::class,  'bahanbaku_id', 'id');
    }
}
