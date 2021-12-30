<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function save($request)
    {
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return $user;
    }
}
