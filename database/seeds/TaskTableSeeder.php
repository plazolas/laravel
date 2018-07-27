<?php

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class TaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
          INSERT INTO `tasks` (`id`, `name`, `created_at`, `updated_at`) VALUES
            (0, 'Git pull laravel repository', '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."'),
            (0, 'run composer on app root directory', '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."'),
            (0, 'create MySQL Database', '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."'),
            (0, 'Update database cofig file for your MySQL credential', '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."'),
            (0, 'Login as admin and change password', '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."')  
        ");
    }
}
