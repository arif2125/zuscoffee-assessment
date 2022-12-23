<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

         //Roles
            DB::table('roles')->insert([
                'name' => 'Admin',
            ]);

            DB::table('roles')->insert([
                'name' => 'Finance',
            ]);

          
            //Users
            DB::table('users')->insert([
                'name' => 'admin',
                'email' => 'admin@test.com',
                'password' => Hash::make('password')
            ]);

            DB::table('role_user')->insert([
                'role_id' => 1,
                'user_id' => 1
            ]);

            DB::table('user_details')->insert([
                'user_id' => 1,
                'age' => 28,
                'gender' => 'Male',
                'phone' => 0000
            ]);

    }
}
