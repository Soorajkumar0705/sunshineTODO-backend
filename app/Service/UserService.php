<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserService
{

    public function register($payload)
    {
        return User::create([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => $payload['password']
        ]);
    }

    public function login($payload)
    {
        $user = User::where('email', $payload['email'])->first();

        if ($user && Hash::check($payload['password'], $user->password)) {
            return $user;
        }

        return null;
    }

    public function generateToken(int $length = 128){
        return Str::random($length);
    }

}