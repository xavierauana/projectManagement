<?php

namespace App\Http\Requests\Projects\Invocies;

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
        return auth()->user()->can('create_invoice');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'due_date'             => 'required|date|after:today',
            'invoice_number'       => 'required|unique:invoices',
            'internal_note'        => 'nullable',
            'note'                 => 'nullable',
            'status'               => 'sometimes|in:' . implode(',',
                    ProjectStatus::values()),
            'items'                => 'nullable',
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
