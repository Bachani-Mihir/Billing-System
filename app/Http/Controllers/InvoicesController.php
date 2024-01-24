<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{
    public function index()
    {
        $this->authorize('IsAllowed', [Invoice::class,'owner']);

        $invoices = Invoice::where('user_id', Auth::user()->id)->get();

        return $invoices;
    }

    public function show($invoice_id)
    {
        $invoice = Invoice::where('id', $invoice_id)->first();

        $this->authorize('isInvoiceOwner', $invoice);

        return $invoice;
    }

    public function store(InvoiceRequest $request)
    {
        $this->authorize('IsAllowed', [Invoice::class,'employee']);

        $invoice = Auth::user()->invoices()->create($request->validated());

        return $invoice;
    }

    public function update(InvoiceRequest $request,$invoice_id)
    {
        $invoice = Invoice::find($invoice_id);

        $this->authorize('isOwner', $invoice);

        $updated_invoice = Invoice::where('id', $invoice_id)->update($request->validated());

        return $updated_invoice;
    }

    public function destroy($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);

        $this->authorize('isInvoiceOwner', $invoice);

        $deleted_invoice = Invoice::where('id', $invoice_id)->delete();

        return $deleted_invoice;
    }

    public function getInvoicesForBusiness($business_id)
    {
        $this->authorize('IsBusinessOwner' , [Invoice::class , $business_id]);

        $invoices = Invoice::where('business_id', $business_id)->get();

        return $invoices;
    }

}
