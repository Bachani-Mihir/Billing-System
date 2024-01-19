<?php

namespace App\Policies;

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
        if (Gate::allows('role', 'admin')) {
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

    public function view()
    {
        if (Gate::allows('isInvoiceOwner')) {
            return true;
        }
    }

    public function viewAny()
    {
        if (Gate::allows('isInvoiceOwner')) {
            return true;
        }
    }
}
