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
            ['company_name' => 'seir_o_safar', 'phone_number' => '+982133333333','address' => 'tehran',
                'created_at' => '2021-10-08 ', 'updated_at' => '2021-10-08'],
            ['company_name' => 'mahan', 'phone_number' => '+982144444444','address' => 'tehran',
                'created_at' => '2021-10-08 ', 'updated_at' => '2021-10-08'],
            ['company_name' => 'hamsafar', 'phone_number' => '+982155555555','address' => 'tehran',
                'created_at' => '2021-10-08', 'updated_at' => '2021-10-08'],

        ];
        Company::insert($companies);
    }
}
