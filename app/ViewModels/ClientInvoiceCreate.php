<?php

namespace App\ViewModels;

use App\Client;
use App\Product;
use Spatie\ViewModels\ViewModel;

class ClientInvoiceCreate extends ViewModel
{
    /**
     * @var \App\Client
     */
    public $client;

    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function products() {
        return Product::all();
    }
}
