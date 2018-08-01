<?php

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
          INSERT INTO `clients` (`id`, `name`, `logo`, `host`,`description`, `created_at`, `updated_at`) VALUES
            (1, 'Waltz Realty','waltzrealty.png' ,'http://waltzrealty.com','Waltz Realty Commercial Properties', '".date('Y-m-d h:i:s')."', '".date('Y-m-d h:i:s')."')
        ");
    }
}
