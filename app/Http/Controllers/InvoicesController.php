<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{
    public function index()
    {
        $this->authorize('IsAllowed', [Invoice::class, 'employee']);

        $invoices = Invoice::where('business_id', Auth::user()->business_id)
                    ->where('user_id', Auth::user()->id)
                    ->get();

        return $invoices;
    }

    public function show($invoice_id)
    {
        $this->authorize('IsAllowed', [Invoice::class, 'employee']);

        $invoice = Invoice::where('id', $invoice_id)->first();

        $this->authorize('IsInvoiceOwner', $invoice);

        return $invoice;
    }

    public function store(InvoiceRequest $request)
    {
        $this->authorize('IsAllowed', [Invoice::class, 'employee']);

        $invoice_data = $request->validated();

        $invoice_data['business_id'] = Auth::user()->business_id;
        // $invoice = Auth::user()->businesses()->invoices()->create($invoice_data);
        $invoice = Auth::user()->invoices()->create($invoice_data);

        return $invoice;
    }

    public function update(InvoiceRequest $request, $invoice_id)
    {
        $this->authorize('IsAllowed', [Invoice::class, 'employee']);

        $invoice = Invoice::find($invoice_id);

        $this->authorize('IsInvoiceOwner', $invoice);

        $updated_invoice = Invoice::where('id', $invoice_id)->update($request->validated());

        return $updated_invoice;
    }

    public function destroy($invoice_id)
    {
        $this->authorize('IsAllowed', [Invoice::class, 'employee']);

        $invoice = Invoice::find($invoice_id);

        $this->authorize('IsInvoiceOwner', $invoice);

        $deleted_invoice = Invoice::where('id', $invoice_id)->delete();

        return $deleted_invoice;
    }

}
