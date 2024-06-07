<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $productManager = Role::create(['name' => 'Product Manager']);

        $admin->givePermissionTo([
            'user/index',
            'user/show',
            'user/store',
            'user/create',
            'user/update',
            'user/edit',
            'user/destroy',

            'master/products/index',
            'master/products/show',
            'master/products/store',
            'master/products/create',
            'master/products/update',
            'master/products/edit',
        ]);

        $productManager->givePermissionTo([
            'master/products/index',
            'master/products/show',
            'master/products/store',
            'master/products/create',
            'master/products/update',
            'master/products/edit',
        ]);
    }
}
