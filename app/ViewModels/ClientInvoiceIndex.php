<?php

namespace App\ViewModels;

use App\Client;
use App\Enums\InvoiceStatus;
use App\Invoice;
use App\Project;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\ViewModels\ViewModel;

class ClientInvoiceIndex extends ViewModel
{
    /**
     * @var \App\Client
     */
    public $client;
    private $perPage = 15;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function totalRemainingAmount() {
        $sum = $this->client->invoices()->withStatus(InvoiceStatus::Active())
                            ->get()->sum->remaining();
        $sum += Invoice::join('projects', 'invoices.billable_id', '=',
            'projects.id')
                       ->where("invoices.billable_type", Project::class)
                       ->join('clients', 'clients.id', '=',
                           'projects.client_id')
                       ->select('invoices.*')
                       ->withStatus(InvoiceStatus::Active())
                       ->get()->sum->remaining();


        return money_format('%i', $sum);
    }

    public function projectInvoices() {

        $raw_query = Invoice::join('projects', 'invoices.billable_id', '=',
            'projects.id')
                            ->where("invoices.billable_type", Project::class)
                            ->join('clients', 'clients.id', '=',
                                'projects.client_id')
                            ->select('invoices.*');

        $totalCount = $raw_query->count();

        $pageName = "projectInvoicePage";

        $page = request()->input($pageName) ?: 1;
        if ($page) {
            $skip = $this->perPage * ($page - 1);
            $raw_query = $raw_query->take($this->perPage)->skip($skip);
        } else {
            $raw_query = $raw_query->take($this->perPage)->skip(0);
        }

        $items = $raw_query->get();

        $parameters = request()->getQueryString();
        $parameters = preg_replace('/&' . $pageName . '(=[^&]*)?|^' . $pageName . '(=[^&]*)?&?/',
            '', $parameters);

        $path = "?" . $parameters;


        $paginator = new LengthAwarePaginator($items, $totalCount,
            $this->perPage,
            $page);
        $paginator = $paginator->withPath($path);
        $paginator->setPageName($pageName);

        return $paginator;

    }

    public function invoices() {
        return $this->client->invoices()->paginate($this->perPage);
    }
}
