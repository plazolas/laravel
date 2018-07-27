<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@laravelrealstate.com',
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ]);
        DB::table('users')->insert([
            'name' => 'guest',
            'email' => 'guest@laravelrealstate.com',
            'password' => bcrypt('guest'),
            'role' => 'guest'
        ]);
        DB::table('users')->insert([
            'name' => 'manager',
            'email' => 'manager@laravelrealstate.com',
            'password' => bcrypt('manager'),
            'role' => 'guest'
        ]);
         DB::table('users')->insert([
            'name' => 'registered',
            'email' => 'registered@laravelrealstate.com',
            'password' => bcrypt('registered'),
            'role' => 'registered'
        ]);
    }
}
