<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function IsAdmin()
    {
        if (Gate::allows('role', 'admin')) {
            return true;
        }
    }
}
