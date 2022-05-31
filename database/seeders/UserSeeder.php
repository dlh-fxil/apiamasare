<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Developer',
            'email' => 'developer@app.dev',
            'username' => 'developer',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            // ]);
        ])->assignRole('Developer');
        User::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'username' => 'superAdmin',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            // ]);
        ])->assignRole('Super Admin');


        // User::factory(5)->create()
        //     ->each(
        //         function ($user) {
        //             $user->assignRole(['name' => 'User']);
        //         }
        //     );
    }
}
