<?php
/**
 * Author: Xavier Au
 * Date: 2019-04-10
 * Time: 02:58
 */

namespace App\Services;


use App\Contracts\BillableInterface;
use App\Invoice;
use App\InvoiceItem;
use Illuminate\Support\Facades\DB;

class CreateInvoiceService
{
    public function create(array $data, BillableInterface $billable = null
    ): Invoice {
        DB::beginTransaction();

        try {
            $items = collect([]);
            $index = array_search('items', array_keys($data));

            if ($index !== false) {
                $items = collect(array_splice($data, $index, 1)['items']);
            }

            $invoice = $billable ?
                $billable->createInvoice($data) :
                Invoice::create($data);
            $invoice->addItems($items->map(function (array $item) {
                return new InvoiceItem($item);
            }));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $invoice;

    }
}