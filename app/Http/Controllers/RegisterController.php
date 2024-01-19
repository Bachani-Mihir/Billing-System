<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationFormRequest;
use App\Models\User;

class RegisterController extends Controller
{
    public function store(RegistrationFormRequest $request)
    {
        $user = User::create($request->validated());

        if ($user) {
            return response()->json([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
            ]);
        }
    }
}
