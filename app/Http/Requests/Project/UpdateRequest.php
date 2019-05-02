<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return optional($this->user())->can('edit_project', $this->project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'title'       => "required",
            'start_date'  => "required|date",
            'end_date'    => "required|date|after:start_date",
            'items'       => 'nullable',
            'items.*.id'  => 'sometimes|exists:products,id',
            'items.*.qty' => 'sometimes|numeric|gt:0',
        ];
    }
}
