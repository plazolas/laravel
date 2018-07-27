<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->command->info('users table seeded!');
        $this->call(TaskTableSeeder::class);
        $this->command->info('tasks table seeded!');
    }
}
