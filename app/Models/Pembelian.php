<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';

    protected $fillable = ['no_po', 'supplier_id', 'bahanbaku_id',  'qty', 'harga', 'subtotal', 'users_id', 'status'];

    public function purchaseorder()
    {
        return $this->belongsToMany(Bahanbaku::class);
    }
}
