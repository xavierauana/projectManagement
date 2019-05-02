<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-07
 * Time: 11:52
 */

namespace App\ValidationRules;


use Exception;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class HasInvoiceItem implements Rule
{


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        try {
            $index = explode('.', $attribute)[1];
            $type = request()->get('items')[(int)$index]['product_type'];
            $dbTable = app()->make($type)->getTable();

            return !!DB::table($dbTable)->find($value);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message() {
        return 'The :attribute does not exists.';
    }
}