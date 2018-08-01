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
            'client_id' => 1,
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ]);
        DB::table('users')->insert([
            'name' => 'guest',
            'email' => 'guest@laravelrealstate.com',
            'client_id' => 1,
            'password' => bcrypt('guest'),
            'role' => 'guest'
        ]);
        DB::table('users')->insert([
            'name' => 'manager',
            'email' => 'manager@laravelrealstate.com',
            'client_id' => 1,
            'password' => bcrypt('manager'),
            'role' => 'manager'
        ]);
         DB::table('users')->insert([
            'name' => 'registered',
            'email' => 'registered@laravelrealstate.com',
            'client_id' => 1,
            'password' => bcrypt('registered'),
            'role' => 'registered'
        ]);
    }
}
