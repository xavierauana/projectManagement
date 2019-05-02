<?php

namespace App\Http\Controllers;

use App\Http\Requests\Projects\Invocies\StoreRequest;
use App\Invoice;
use App\Project;
use App\Services\CreateInvoiceService;
use App\ViewModels\CreateProjectInvoice;
use Illuminate\Http\Request;

class ProjectInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Project $project
     * @return void
     */
    public function index(Project $project) {
        if (!$this->authorize('browse_invoice')) {
            abort(403);
        }
        $invoices = $project->invoices()
                            ->search(request()->query('keyword'))
                            ->paginate();

        return view('projects.invoices.index', compact('invoices', 'project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Project $project
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Project $project) {
        $this->authorize('create_invoice', $project);

        $project->load('products');

        return view("projects.invoices.create",
            new CreateProjectInvoice($project));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Projects\Invocies\StoreRequest $request
     * @param \App\Services\CreateInvoiceService                $service
     * @param \App\Project                                      $project
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(
        StoreRequest $request, CreateInvoiceService $service, Project $project
    ) {

        $service->create($request->validated(), $project);

        return redirect()->route('projects.invoices.index', $project)
                         ->withMessage('New invoice created!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Project $project
     * @param \App\Invoice $invoice
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Project $project, Invoice $invoice) {
        $this->authorize('edit_invoice', $invoice);
        if (!$invoice->billable->is($project)) {
            abort(403);
        }
        $invoice->load(['billable.client', 'items.product']);

        return view("projects.invoices.edit", compact('project', 'invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(
        Request $request, $id
    ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(
        $id
    ) {
        //
    }
}
