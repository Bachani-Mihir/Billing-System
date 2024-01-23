<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('user_id', Auth::user()->id)->get();

        return $invoices;
    }

    public function show($invoice)
    {
        $this->authorize('isInvoiceOwner', $invoice);

        $invoice = Invoice::where('id', $invoice)->first();

        return $invoice;
    }

    public function store(InvoiceRequest $request)
    {
        $this->authorize('create',Invoice::class);

        $invoice = Auth::user()->invoices()->create($request->validated());

        return $invoice;
    }

    public function update(InvoiceRequest $request,$invoice_id)
    {
        $invoice = Invoice::find($invoice_id);

        $this->authorize('isInvoiceOwner', $invoice);

        $updated_invoice = Invoice::where('id',$invoice_id)->update($request->validated());

        return $updated_invoice;
    }

    public function destroy($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);

        $this->authorize('isInvoiceOwner', $invoice);

        $deleted_invoice = Invoice::where('id', $invoice_id)->delete();

        return $deleted_invoice;
    }
}
