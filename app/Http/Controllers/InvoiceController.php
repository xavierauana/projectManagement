<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\Invoice\PayRequest;
use App\Http\Requests\Invoice\StoreRequest;
use App\Invoice;
use App\Project;
use App\Services\CreateInvoiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index() {
        $this->authorize('browse_invoice');

        $invoices = Invoice::search(request()->query('keyword'))
                           ->with('billable')
                           ->orderBy('created_at', 'desc')
                           ->paginate();

        return view("invoices.index", compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $this->authorize('create_invoice');

        $projects = Project::pluck('id', 'title');
        $clients = Client::pluck('id', 'name');

        return view("invoices.create", compact('projects', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Invoice\StoreRequest $request
     * @param \App\Services\CreateInvoiceService      $service
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(StoreRequest $request, CreateInvoiceService $service
    ) {
        $service->create($request->validated());

        return redirect()->route("invoices.index")
                         ->withMessage('New invoice created');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Invoice $invoice) {
        $this->authorize('read_invoice');

        $invoice->load(['payments','billable']);

        return view("invoices.show", compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Invoice             $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice) {
        $this->authorize('delete_invoice', $invoice);

        $invoice->delete();

        return response()->json(['status' => 'completed']);
    }

    public function pay(PayRequest $request) {

        $formObject = $request->validated();

        $formObject->getInvoice()->pay($formObject->getAmount());

        return redirect()->back()->withMessage("Invoice updated!");
    }

    public function getOptions(Request $request): JsonResponse {
        if ($request->wantsJson()) {

            $type = $request->query('type');

            switch ($type) {
                case Client::class:
                    $result = Client::all();
                    break;
                default:
                    $result = Project::all();
            }

            return response()->json($result);

        }
    }
}
