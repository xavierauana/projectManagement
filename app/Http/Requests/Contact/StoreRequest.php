<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return request()->user()->can('create_contact', $this->client);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        $rules = [
            'first_name'            => 'required',
            'last_name'             => 'required',
            'addresses'             => 'sometimes',
            'addresses.*.address_1' => 'required',
            'addresses.*.address_2' => 'nullable',
            'addresses.*.address_3' => 'nullable',
            'phones'                => 'sometimes',
            'phones.*.number'       => 'required',
            'phones.*.type'         => 'required|string',
            'emails'                => 'sometimes',
            'emails.*.email'        => 'required|email',
            'emails.*.type'         => 'required|string',
        ];

        if (is_null($this->client)) {
            $rules['client_id'] = 'required|exists:clients,id';
        }

        return $rules;
    }
}
