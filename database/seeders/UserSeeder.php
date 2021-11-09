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
            ['name' => 'Admin', 'username' => 'Admin','email' => 'Admin@gmail.com', 'password' => Hash::make('1234Asdf'),
                'created_at' => '2021-10-08 ', 'updated_at' => '2021-10-08'],
            ['name' => 'Lara', 'username' => 'Lara', 'email' => 'Lara@gmail.com', 'password' => Hash::make('1234Asdf'),
                'created_at' => '2021-10-08', 'updated_at' => '2021-10-08'],
            ['name' => 'Ana','username' => 'Ana' , 'email' => 'Ana@gmail.com', 'password' => Hash::make('1234Asdf'),
                'created_at' => '2021-10-09', 'updated_at' => '2021-10-09'],

        ];
        User::insert($users);
    }
}
