<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return $this->user() and $this->user()->can('create_project');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'client_id'   => 'required|exists:clients,id',
            'title'       => 'required',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after:start_date',
            'items'       => 'nullable',
            'items.*.id'  => 'sometimes|exists:products,id',
            'items.*.qty' => 'sometimes|numeric|gt:0',
        ];
    }
}
