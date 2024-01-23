<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function valid(LoginFormRequest $request)
    {
        if ($request->validated()) {
            $user = $request->authenticate();

            if ($user) {
                Auth::guard('web')->login($user);

                $tokenName = ucfirst($user->role).'Token';

                $token = $request->user()->createToken($tokenName, [$user->role])->plainTextToken;

                return response()->json([
                    'token' => $token,
                    'role' => $user->role,
                ]);
            }
        }
    }
}
