<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'id' => 1,
        //     'name' => 'admin',
        //     'email' => 'admin@admin.com',
        //     'password' => Hash::make('secret'),
        //     'role' => 'admin',
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'jule',
            'email' => 'fefekjule@gmail.com',
            'password' => Hash::make('jule123'),
            'role' => 'employee',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
