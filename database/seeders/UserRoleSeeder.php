<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert ([
            ['id' => 1, 'role_name' => 'superUser', 'created_at' => '2021-10-08 ', 'updated_at' => '2021-10-08'],
            ['id' => 2,'role_name' => 'admin', 'created_at' => '2021-10-08 ', 'updated_at' => '2021-10-08'],
            ['id' => 3,'role_name' => 'user', 'created_at' => '2021-10-08 ', 'updated_at' => '2021-10-08'],
            ['id' => 4,'role_name' => 'company_owner', 'created_at' => '2021-10-08 ', 'updated_at' => '2021-10-08'],
        ]);
    }
}
