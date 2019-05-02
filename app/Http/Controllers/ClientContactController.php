<?php

namespace App\Http\Controllers;

use App\Client;
use App\Contact;
use App\Http\Requests\Contact\StoreRequest;
use App\Http\Requests\Contact\UpdateRequest;
use App\Services\CreateContactService;

class ClientContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Client $client
     * @return void
     */
    public function index(Client $client) {
        $this->authorize('browse_contact', $client);
        $contacts = $client->contacts()
                           ->search(request()->query('keyword'))
                           ->paginate();

        return view("clients.contacts.index", compact('client', 'contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Client $client
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client) {
        $this->authorize('create_contact', $client);

        return view("clients.contacts.create", compact('client'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Contact\StoreRequest $request
     * @param \App\Services\CreateContactService      $service
     * @param \App\Client                             $client
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(
        StoreRequest $request, CreateContactService $service, Client $client
    ) {
        $service->create($request->validated(), $client);

        return redirect()->route("clients.contacts.index", $client)
                         ->withMessage('New contact created!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Client  $client
     * @param \App\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client, Contact $contact) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Http\Requests\Contact\UpdateRequest $request
     * @param \App\Client                              $client
     * @param \App\Contact                             $contact
     * @return void
     */
    public function edit(Client $client, Contact $contact
    ) {
        $this->authorize('edit_contact', $contact);

        return view("clients.contacts.edit", compact('client', 'contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Client              $client
     * @param \App\Contact             $contact
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateRequest $request, Client $client, Contact $contact
    ) {
        $contact->update($request->validated());

        return redirect()->route('clients.contacts.index', $client)
                         ->withMessage('Contact updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Client  $client
     * @param \App\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client, Contact $contact) {

        $this->authorize('delete_contact', $contact);

        if (!$contact->client->is($client)) {
            abort(403);
        }

        $contact->delete();

        return redirect()->route('clients.contacts.index', $client)
                         ->withMessage('Contact deleted!');
    }
}
