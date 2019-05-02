<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-07
 * Time: 11:52
 */

namespace App\ValidationRules;


use App\Contracts\InvoiceItemInterface;
use Exception;
use Illuminate\Contracts\Validation\Rule;

class IsInvoiceItem implements Rule
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
            return app()->make($value) instanceof InvoiceItemInterface;
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
        return 'The :attribute must be an invoice item.';
    }
}