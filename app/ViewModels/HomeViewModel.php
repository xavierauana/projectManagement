<?php

namespace App\ViewModels;

use App\Enums\InvoiceStatus;
use App\Invoice;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;

class HomeViewModel extends ViewModel
{
    public function invoiceToBePaid() {
        $invoices = Invoice::withStatus(InvoiceStatus::Active())
                           ->get()
                           ->groupBy(function (Invoice $invoice) {
                               return $invoice->getPayee()->getTitle();
                           })
                           ->map(function (Collection $group) {
                               return $group->reduce(function (
                                   $carry, Invoice $invoice
                               ) {
                                   $carry[$invoice->invoice_number] = $invoice->invoice_number;

                                   return $carry;
                               }, []);
                           });

        return $invoices;
    }
}
