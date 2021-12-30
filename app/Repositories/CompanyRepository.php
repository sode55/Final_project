<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    public function save($request, $userId)
    {
        $company = Company::create([
            'company_name' => $request->company_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'address' => $request->address,
            'user_id' => $userId,
        ]);

        return $company;
    }

    public function list()
    {
        $company = Company::inRandomOrder()->limit(5)
            ->get(['company_name', 'phone_number', 'email', 'address']);

        return $company;
    }
}
