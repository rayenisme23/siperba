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
        return $this->hasMany(Pembelian::class, 'id', 'pembelian_id');
    }

    public function bahanBaku()
    {
        return $this->hasMany(Bahanbaku::class, 'id', 'bahanbaku_id');
    }
}
