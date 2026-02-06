<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
       
        Permission::create(['name' => 'create restaurant']);
        Permission::create(['name' => 'edit restaurant']);
        Permission::create(['name' => 'delete restaurant']);
        Permission::create(['name' => 'delete any restaurant']);
        Permission::create(['name' => 'view statistiques']);
        Permission::create(['name' => 'create reservation']);

      
        $admin = Role::create(['name' => 'admin']);
        $restaurateur = Role::create(['name' => 'restaurateur']);
        $client = Role::create(['name' => 'client']);

    

        $admin->givePermissionTo(Permission::all());

        $restaurateur->givePermissionTo([
            'create restaurant',
            'edit restaurant',
            'delete restaurant'
        ]);

        $client->givePermissionTo([
            'create reservation'
        ]);
    }
}
