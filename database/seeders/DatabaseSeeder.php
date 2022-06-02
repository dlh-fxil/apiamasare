<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // OrganisasiSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            PangkatSeeder::class,
            JabatanSeeder::class,
            UnitSeeder::class,
            SubUnitSeeder::class,
            // PegawaiSeeder::class,
            // SuratKeluarSeeder::class,
            // SuratMasukSeeder::class,
            // UraianTugasSeeder::class
            ProgramKegiatanSeeder::class


        ]);
        // \App\Models\User::factory(40)->create();
    }
}
