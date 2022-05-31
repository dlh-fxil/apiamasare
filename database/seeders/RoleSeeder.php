<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserManagement\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['description' => 'Descripsi Role', 'name' => 'Developer', 'level' => 1002]);
        Role::create(['description' => 'Descripsi Role', 'name' => 'Super Admin', 'level' => 1001]);
        Role::create(['description' => 'Descripsi Role', 'name' => 'Admin', 'level' => 99]);
        Role::create(['description' => 'Descripsi Role', 'name' => 'Pegawai', 'level' => 1]);
    }
}
