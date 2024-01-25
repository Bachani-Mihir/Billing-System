<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class InvoicePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function IsAllowed(User $user, $ExpectedRole)
    {
        if (Gate::allows('role', $ExpectedRole)) {
            return true;
        }
    }

    public function IsInvoiceOwner(User $user, $invoice)
    {
        if (Gate::allows('IsInvoiceOwner', $invoice)) {
            return true;
        }
    }
}
