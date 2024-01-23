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
        $this->authorize('viewAny', Invoice::class);

        $user = auth()->user();

        $invoices = Invoice::where('user_id', Auth::user()->id)->get();

        return $invoices;
    }

    public function show($invoice)
    {
        $this->authorize('view', Invoice::class);

        $invoice = Invoice::where('id', $invoice)->first();

        return $invoice;
    }

    public function store(InvoiceRequest $request)
    {
        $this->authorize('create', Invoice::class);

        $invoice = Auth::user()->invoices()->create($request->validated());

        return $invoice;
    }

    public function update($invoice)
    {
        $this->authorize('update', Invoice::class);

        $updated_invoice = Invoice::where('id', $invoice)->update();

        return $updated_invoice;
    }

    public function destroy($invoice)
    {
        $this->authorize('delete', Invoice::class);

        $deleted_invoice = Invoice::where('id', $invoice)->delete();

        return $deleted_invoice;
    }
}
