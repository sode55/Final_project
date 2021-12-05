<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        $users = [
            ['name' => 'SuperUser', 'username' => 'SuperUser', 'mobile' =>'+9891223277991',
                'email' => 'SuperUser@gmail.com', 'password' => Hash::make('1234Asdf'),
                'role_id' => 1, 'created_at' => '2021-10-08 ', 'updated_at' => '2021-10-08'],
            ['name' => 'Admin', 'username' => 'Admin', 'mobile' =>'+9891223277992',
                'email' => 'Admin@gmail.com', 'password' => Hash::make('1234Asdf'),
                'role_id' => 2, 'created_at' => '2021-10-08 ', 'updated_at' => '2021-10-08'],
            ['name' => 'Lara', 'username' => 'Lara', 'mobile' =>'+9891223277993',
                'email' => 'Lara@gmail.com', 'password' => Hash::make('1234Asdf'),
                'role_id' => 3, 'created_at' => '2021-10-08', 'updated_at' => '2021-10-08'],
            ['name' => 'Ana','username' => 'Ana' , 'mobile' =>'+9891223277994',
                'email' => 'Ana@gmail.com', 'password' => Hash::make('1234Asdf'),
                'role_id' => 4, 'created_at' => '2021-10-09', 'updated_at' => '2021-10-09'],

        ];
        User::insert($users);
    }
}
