<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\Client\Invoice\StoreRequest;
use App\Invoice;
use App\Services\CreateInvoiceService;
use App\ViewModels\ClientInvoiceCreate;
use App\ViewModels\ClientInvoiceIndex;
use Illuminate\Http\Request;

class ClientInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function index(Client $client) {
        return view("clients.invoices.index", new ClientInvoiceIndex($client));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client) {
        return view("clients.invoices.create",
            new ClientInvoiceCreate($client));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Client              $client
     * @return \Illuminate\Http\Response
     */
    public function store(
        StoreRequest $request, Client $client, CreateInvoiceService $service
    ) {
        $invoice = $service->create($request->validated(), $client);
        return response()->json(['status' => 'completed']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Client  $client
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client, Invoice $invoice) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Client  $client
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client, Invoice $invoice) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Client              $client
     * @param \App\Invoice             $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client, Invoice $invoice) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Client  $client
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client, Invoice $invoice) {
        //
    }
}
