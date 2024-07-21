<?php

namespace Database\Seeders;

use App\Models\Departemen;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama_user' => 'Administrator',
            'email' => 'administrator@gmail.com',
            'departemen_id' => '1',
            'alamat' => 'Jl. Administrator',
        ])->assignRole('Administrator');

        User::create([
            'nama_user' => 'gudang',
            'email' => 'gudangn@gmail.com',
            'departemen_id' => '2',
            'alamat' => 'Jl. Gudang',
        ])->assignRole('Gudang');

        User::create([
            'nama_user' => 'pembelian',
            'email' => 'pembelian@gmail.com',
            'departemen_id' => '3',
            'alamat' => 'Jl. Pembelian',
        ])->assignRole('Pembelian');

        User::create([
            'nama_user' => 'produksi',
            'email' => 'produksin@gmail.com',
            'departemen_id' => '4',
            'alamat' => 'Jl. Produksi',
        ])->assignRole('Produksi');

        Departemen::create([
            'nama_departemen' => 'IT',
        ]);
        Departemen::create([
            'nama_departemen' => 'Gudang',
        ]);
        Departemen::create([
            'nama_departemen' => 'Pembelian',
        ]);
        Departemen::create([
            'nama_departemen' => 'Produksi',
        ]);

        DB::table('supplier')->insert([
            [
                'nama_supplier' => 'Supplier A',
                'email' => 'suppliera@gmail.com',
                'no_hp' => '08324762434',
                'alamat' => 'Flower city no. 23A',
            ],
            [
                'nama_supplier' => 'Supplier B',
                'email' => 'supplierb@gmail.com',
                'no_hp' => '0836473643',
                'alamat' => 'Flower city no. 23B',
            ],
            [
                'nama_supplier' => 'Supplier C',
                'email' => 'supplierc@gmail.com',
                'no_hp' => '0897377737',
                'alamat' => 'Flower city no. 23C',
            ],
        ]);
        DB::table('bahanbaku')->insert([
            [
                'nama_bahanbaku' => 'Bubuk Benang',
                'harga' => 50000,
                'satuan' => 'Kg',
                'stok' => 350,
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
