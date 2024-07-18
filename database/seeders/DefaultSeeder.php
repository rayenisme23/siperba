<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nama_user' => 'Canriyan',
                'email' => 'canriyann@gmail.com',
                'password' => Hash::make('B@ndung357'),
                'departemen_id' => '1',
                'alamat' => 'Jl. Cangkuang'
            ],
        ]);
        DB::table('departemen')->insert([
            [
                'nama_departemen' => 'IT',
            ],
        ]);
        DB::table('supplier')->insert([
            [
                'nama_supplier' => 'Supplier A',
                'email' => 'suppliera@gmail.com',
                'no_hp' => '08324762434',
                'alamat' => 'Flower city no. 23A'
            ],
            [
                'nama_supplier' => 'Supplier B',
                'email' => 'supplierb@gmail.com',
                'no_hp' => '0836473643',
                'alamat' => 'Flower city no. 23B'
            ],
            [
                'nama_supplier' => 'Supplier C',
                'email' => 'supplierc@gmail.com',
                'no_hp' => '0897377737',
                'alamat' => 'Flower city no. 23C'
            ],
        ]);
        DB::table('bahanbaku')->insert([
            [
                'nama_bahanbaku' => 'Bubuk Benang',
                'harga' => 50000,
                'satuan' => 'Kg',
                'stok' => 350
            ],
            [
                'nama_bahanbaku' => 'Obat',
                'harga' => 75000,
                'satuan' => 'Kg',
                'stok' => 350,
            ],
            [
                'nama_bahanbaku' => 'Pewarna',
                'harga' => 65000,
                'satuan' => 'Liter',
                'stok' => 350,
            ],
        ]);
    }
}
