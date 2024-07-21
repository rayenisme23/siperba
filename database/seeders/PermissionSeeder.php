<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = [
            'master-user',
            'master-bahanbaku',
            'master-departemen',
            'master-supplier',
            'manajemen-pembelian',
            'manajemen-permintaan'
        ];

        foreach ($permission as $p) {
            Permission::create(['name' => $p]);
        }
    }
}
