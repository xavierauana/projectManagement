<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Http\Requests\Contact\StoreRequest;
use App\Services\CreateContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->authorize('browse_contact');

        $contacts = Contact::with('client')
                           ->search(request()->query('keyword'))
                           ->paginate();

        return view("contacts.index", compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Contact\StoreRequest $request
     * @param \App\Services\CreateContactService      $service
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(StoreRequest $request, CreateContactService $service
    ) {

        $service->create($request->validated());

        return redirect()->route('contacts.index')
                         ->withMessage('New contact created!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Contact $contact
     * @return void
     */
    public function show(Contact $contact) {
        $contact->load('client');

        return view("contacts.show", compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Contact             $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact) {
        //
    }
}
