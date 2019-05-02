<?php

namespace App\Http\Requests\Invoice;

use App\Http\FormObject\PayInvoiceFormObject;
use App\Invoice;
use Illuminate\Foundation\Http\FormRequest;

class PayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return request()->user()->can('edit_invoice');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'invoice_number' => 'required|exists:invoices',
            'amount'         => 'required|numeric|gt:0|lte:' . Invoice::whereInvoiceNumber($this->input('invoice_number'))
                                                                      ->first()
                                                                      ->remaining(),
        ];
    }

    public function validated(): PayInvoiceFormObject {
        $data = parent::validated();

        return new PayInvoiceFormObject($data['invoice_number'],
            $data['amount']);
    }
}
