<?php

namespace App\Http\Requests\Client\Invoice;

use App\Enums\ProjectStatus;
use App\ValidationRules\HasInvoiceItem;
use App\ValidationRules\IsInvoiceItem;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return $this->user()->can('create_invoice', $this->client);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'billable_type'        => 'required|in:App\\Client,App\\Project',
            'billable_id'          => 'required|numeric',
            'due_date'             => 'required|date|after:today',
            'invoice_number'       => 'required|unique:invoices',
            'note'                 => 'nullable',
            'internal_note'        => 'nullable',
            'status'               => 'sometimes|in:' . implode(',',
                    ProjectStatus::values()),
            'items'                => 'sometimes',
            'items.*.product_type' => [
                'required',
                new IsInvoiceItem
            ],
            'items.*.product_id'   => [
                'required',
                new HasInvoiceItem
            ],
            'items.*.unit_price'   => 'required|gt:0',
            'items.*.quantity'     => 'required|gt:0',
        ];
    }
}
