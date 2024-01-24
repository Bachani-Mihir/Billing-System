<?php

namespace App\Policies;

use App\Models\Invoice;
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

    public function IsAllowed(User $user,$ExpectedRole)
    {
        if (Gate::allows('role', $ExpectedRole)) {
            return true;
        }
    }

    public function IsOwner(User $user,$invoice)
    {
        if (Gate::allows('isInvoiceOwner', $invoice)) {
            return true;
        }
    }

    public function IsBusinessOwner(User $user,$business_id)
    {
        if (Gate::allows('IsBusinessOwner', $business_id)) {
            return true;
        }
    }

}
