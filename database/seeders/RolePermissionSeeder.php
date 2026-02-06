<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {

        Permission::firstOrCreate(['name' => 'create restaurant']);
        Permission::firstOrCreate(['name' => 'edit own restaurant']);
        Permission::firstOrCreate(['name' => 'delete own restaurant']);
        Permission::firstOrCreate(['name' => 'view restaurants']);
        Permission::firstOrCreate(['name' => 'add favorite']);
        Permission::firstOrCreate(['name' => 'view details']);
        Permission::firstOrCreate(['name' => 'manage restaurants']);
        Permission::firstOrCreate(['name' => 'view statistics']);

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $restaurateur = Role::firstOrCreate(['name' => 'restaurateur']);
        $client = Role::firstOrCreate(['name' => 'client']);

        $admin->syncPermissions(Permission::all());

        $restaurateur->syncPermissions([
            'create restaurant',
            'edit own restaurant',
            'delete own restaurant',
            'view restaurants'
        ]);

        $client->syncPermissions([
            'view restaurants',
            'add favorite',
            'view details'
        ]);
    }
}
