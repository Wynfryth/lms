<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

// use Spatie\Permission\Models;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'manage class category',
            'manage classes',
            'manage study category',
            'manage employee',
            'view class',
            'view employee'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'name' => $perm
            ]);
        }

        // Academy Admin
        $academyAdminRole = Role::firstOrCreate([
            'name' => 'academy_admin'
        ]);

        $user = User::create([
            'name' => 'Academy Admin',
            'email' => 'gacoan_academy@admin.com',
            'avatar' => 'images/dummyavatar.png',
            'password' => bcrypt('123qwe123')
        ]);

        $user->assignRole($academyAdminRole);

        // Employee
        $employeeRole = Role::firstOrCreate([
            'name' => 'employee'
        ]);

        $employeePermissions = ([
            'manage class',
            'manage employee',
            'view class',
            'view employee'
        ]);

        $employeeRole->syncPermissions($employeePermissions);
    }
}
