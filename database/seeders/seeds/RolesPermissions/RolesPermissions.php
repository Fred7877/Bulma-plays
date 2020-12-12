<?php


namespace Database\Seeders\seeds\RolesPermissions;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissions extends Seeder
{

    public function run()
    {
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $permissionAdmin = Permission::firstOrCreate(['name' => 'enter backend']);

        $roleAdmin->givePermissionTo($permissionAdmin);
        $permissionAdmin->assignRole($roleAdmin);

        $roleUser = Role::firstOrCreate(['name' => 'user']);
        $permissionUser = Permission::firstOrCreate(['name' => 'add comments and replies']);

        $roleUser->givePermissionTo($permissionUser);
        $permissionUser->assignRole($roleUser);

    }
}
