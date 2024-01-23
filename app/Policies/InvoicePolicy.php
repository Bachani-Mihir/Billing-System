<?php

namespace App\Policies;

use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
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

    public function create()
    {
        if (Gate::allows('role','employee')) {
            return true;
        }
    }

    public function IsOwner($invoice)
    {
        if (Gate::allows('isInvoiceOwner',$invoice)) {
            return true;
        }
    }

}
