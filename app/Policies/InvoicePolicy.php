<?php

namespace App\Policies;

use App\Models\Invoice;
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
        if (Gate::allows('role', 'employee')) {
            return true;
        }
    }

    public function update()
    {
        if (Gate::allows('isInvoiceOwner')) {
            return true;
        }
    }

    public function delete()
    {
        if (Gate::allows('isInvoiceOwner')) {
            return true;
        }
    }

    public function view($invoice)
    {
        if (Gate::allows('isInvoiceOwner',$invoice)) {
            return true;
        }
    }

    public function viewAny($invoice)
    {
        if (Gate::allows('isInvoiceOwner',$invoice)) {
            return true;
        }
    }
}
