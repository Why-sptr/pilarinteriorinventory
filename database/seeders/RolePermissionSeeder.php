<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $roles = [
            'sales',
            'finance',
            'operasional',
            'superadmin',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Create permissions
        $permissions = [
            'view dashboard',
            'view data barang',
            'view jenis barang',
            'view data customer',
            'view stok barang customer',
            'view pengajuan',
            'view biaya operasional',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        Role::findByName('sales')->givePermissionTo([
            'view dashboard',
            'view data barang',
            'view jenis barang',
            'view data customer',
            'view stok barang customer',
        ]);

        Role::findByName('finance')->givePermissionTo([
            'view dashboard',
            'view data barang',
            'view jenis barang',
            'view pengajuan',
        ]);

        Role::findByName('operasional')->givePermissionTo([
            'view dashboard',
            'view data barang',
            'view jenis barang',
            'view pengajuan',
            'view biaya operasional',
        ]);

        Role::findByName('superadmin')->givePermissionTo(Permission::all());
    }
}
