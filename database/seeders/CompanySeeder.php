<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            ['name' => 'seir_o_safar', 'phone_number' => '+982133333333', 'email' => 'seir_o_safar@gmail.com', 'address' => 'tehran',
                'created_at' => '2021-10-08 ', 'updated_at' => '2021-10-08'],
            ['name' => 'mahan', 'phone_number' => '+982144444444','email' => 'mahan@gmail.com','address' => 'tehran',
                'created_at' => '2021-10-08 ', 'updated_at' => '2021-10-08'],
            ['name' => 'hamsafar', 'phone_number' => '+982155555555','email' => 'hamsafar@gmail.com','address' => 'tehran',
                'created_at' => '2021-10-08', 'updated_at' => '2021-10-08'],

        ];
        Company::insert($companies);
    }
}
