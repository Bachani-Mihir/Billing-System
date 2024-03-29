<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'client_id' => 'required|exists:clients,id',
            'total_amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:draft,sent,paid',
        ];

        if ($this->isMethod('put')) {
            $rules['invoice_number'] = 'required|exists:invoices,invoice_number';
        } else {
            $rules['invoice_number'] = 'required|unique:invoices,invoice_number';
        }

        return $rules;
    }
}
