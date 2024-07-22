<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';

    protected $guarded = [];


    public function user()
    {
        return $this->hasMany(User::class, 'id', 'users_id');
    }

    public function supplier()
    {
        return $this->hasMany(Supplier::class, 'id', 'supplier_id');
    }

    public function relation_pembelian()
    {
        return $this->hasMany(Relation_pembelian::class, 'pembelian_id', 'id');
    }

    public function calculateSubtotal()
    {
        $items = $this->relation_pembelian()
            ->where('pembelian_id', $this->id)
            ->get();

        $subtotal = 0;

        if ($items->count() == 1) {
            $subtotal = $items->first()->total;
        } else {
            foreach ($items as $item) {
                $subtotal += $item->total;
            }
        }

        return $subtotal;
    }
}
