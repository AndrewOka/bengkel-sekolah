<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Brand;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Roles
        $roleManager = Role::create(['role_name' => 'Manager']);
        $roleAdmin   = Role::create(['role_name' => 'Admin']);
        $roleStaff   = Role::create(['role_name' => 'Staff']);

        // 2. Seed Default Users
        User::create([
            'username'      => 'manager',
            'password'      => Hash::make('manager123'),
            'full_name'     => 'Manager Bengkel',
            'role_id'       => $roleManager->role_id,
            'is_active'     => true,
        ]);

        User::create([
            'username'      => 'admin',
            'password'      => Hash::make('admin123'),
            'full_name'     => 'Admin Bengkel',
            'role_id'       => $roleAdmin->role_id,
            'is_active'     => true,
        ]);

        User::create([
            'username'      => 'staff',
            'password'      => Hash::make('staff123'),
            'full_name'     => 'Staff Bengkel',
            'role_id'       => $roleStaff->role_id,
            'is_active'     => true,
        ]);

        // 3. Seed Sample Brands
        Brand::create(['brand_name' => 'Honda']);
        Brand::create(['brand_name' => 'Yamaha']);
        Brand::create(['brand_name' => 'Suzuki']);
        Brand::create(['brand_name' => 'Kawasaki']);
    }
}