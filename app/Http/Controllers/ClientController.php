<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index() {
        $this->authorize('browse_client');

        $clients = Client::search(request()->query('keyword'))->paginate();

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (!$this->authorize('create_client')) {
            abort(403);
        }

        return view('clients.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request) {
        Client::create($request->validated());

        return redirect()->route('clients.index')
                         ->withMessage("Client created!");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Client $client) {
        $this->authorize('read_client', $client);

        $contacts = $client->contacts()
                           ->with(['emails', 'phones'])
                           ->paginate();

        return view("clients.show", compact('client', 'contacts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client) {
        if (!$this->authorize('edit_client')) {
            abort(403);
        }

        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Client              $client
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Client $client) {
        $client->update($request->validated());

        return redirect()->route('clients.index')
                         ->withMessage("Client updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client) {
        if (!$this->authorize('delete_client')) {
            abort(403);
        }

        $client->delete();

        if (request()->ajax()) {
            return response()->json();
        }

        return redirect()->route('clients.index')
                         ->withMessage('Company deleted!');
    }
}
