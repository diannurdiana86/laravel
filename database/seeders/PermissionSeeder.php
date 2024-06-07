<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void //
    {
        $permissions = [
            'role/index', // Menu berikut table = index
            'role/show', // View = show
            'role/store', // Create = store
            'role/create', // CreateView = create
            'role/update', // Update = update
            'role/edit', // UpdateView = edit
            'role/destroy', // Delete = destroy

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
            'master/products/destroy',
        ];

        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'title' => ucwords(preg_replace('/[^\w\s]/u', ' ', $permission))]);
        }
    }
}
