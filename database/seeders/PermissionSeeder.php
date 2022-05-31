<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserManagement\Role;
use App\Models\UserManagement\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findByName('Developer', 'web');

        $tables = ['permissions', 'roles', 'users', 'jabatan', 'pangkat', 'unit', 'subUnit', 'uraianTugas'];
        $permissions = ['viewAny', 'view', 'create', 'update', 'delete', 'restore', 'forceDelete'];
        foreach ($tables as $group) {
            foreach ($permissions as $permission) {
                # code...
                $listPermissions[] = [
                    'group' => $group,
                    'name' => $group . '.' . $permission,
                    'description' => 'Deskripsi ' . $permission . ' ' . $group
                ];
            }
        }

        foreach ($listPermissions as $key) {
            $p = Permission::create($key);
            $role->givePermissionTo($p->name);
        }
    }
}
