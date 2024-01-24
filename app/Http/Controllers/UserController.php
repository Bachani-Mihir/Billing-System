<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('IsAdmin', User::class);

        $users = User::all()->where('business_id', Auth::user()->business_id);

        return $users;
    }

    public function show($user_id)
    {
        $user = User::findOrFail($user_id);

        $this->authorize('IsAdmin', User::class);

        $user = User::where('id', $user->id)->first();

        return $user;
    }

    public function store(UserRequest $request)
    {
        $this->authorize('IsAdmin', User::class);

        $user = User::create($request->validated());

        return $user;
    }

    public function update(UserRequest $request, $user_id)
    {
        $user = User::findOrFail($user_id);

        $this->authorize('IsAdmin', User::class);

        $updated_user = User::where('id', $user->id)->update($request->validated());

        return $updated_user;
    }

    public function destroy($user_id)
    {
        $this->authorize('IsAdmin', User::class);

        $deleted_user = User::where('id', $user_id)->delete();

        return $deleted_user;
    }
}
