<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@corner.my.id',
            'password' => Hash::make('!1234567')
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@corner.my.id',
            'password' => Hash::make('!1234567')
        ]);
        $admin->assignRole('Admin');

        // Creating Product Manager User
        $productManager = User::create([
            'name' => 'Product Manager',
            'email' => 'productmanager@corner.my.id',
            'password' => Hash::make('!1234567')
        ]);
        $productManager->assignRole('Product Manager');
    }
}
