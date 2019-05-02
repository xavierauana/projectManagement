<?php

namespace Tests\Feature;

use App\Client;
use App\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\UserGenerator;

class ManagementContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function get_index_page() {
        $this->withoutExceptionHandling();

        $user = (new UserGenerator())
            ->addPermission("browse_contact")
            ->generate();

        $this->actingAs($user);


        $uri = route("contacts.index");

        $this->get($uri)
             ->assertViewIs('contacts.index')
             ->assertViewHas('contacts');

    }


    /**
     * @test
     */
    public function create_contact_name() {

        $this->withoutExceptionHandling();

        $user = (new UserGenerator())
            ->addPermission("create_contact")
            ->generate();

        $this->actingAs($user);

        $client = factory(Client::class)->create();
        $data = [
            'first_name' => 'Xavier',
            'last_name'  => 'Au',
            'client_id'  => $client->id,
        ];


        $uri = route("contacts.store");

        $this->post($uri, $data)
             ->assertRedirect(route('contacts.index'))
             ->assertSessionHas('message');


        $this->assertDatabaseHas('contacts', [
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'client_id'  => $data['client_id'],
        ]);
    }

    /**
     * @test
     */
    public function create_contact_with_address() {

        $this->withoutExceptionHandling();

        $user = (new UserGenerator())
            ->addPermission("create_contact")
            ->generate();

        $this->actingAs($user);

        $client = factory(Client::class)->create();
        $data = [
            'first_name' => 'Xavier',
            'last_name'  => 'Au',
            'client_id'  => $client->id,
            'addresses'  => [
                [
                    'address_1' => 'Address 1',
                    'address_2' => 'Address 2',
                    'address_3' => 'Address 3',
                ]
            ]
        ];

        $uri = route("contacts.store");

        $this->post($uri, $data);

        $contact = Contact::whereFirstName($data['first_name'])
                          ->whereLastName($data['last_name'])
                          ->whereClientId($data['client_id'])
                          ->first();


        $this->assertDatabaseHas('addresses', [
            'address_1'     => $data['addresses'][0]['address_1'],
            'address_2'     => $data['addresses'][0]['address_2'],
            'address_3'     => $data['addresses'][0]['address_3'],
            'resident_type' => Contact::class,
            'resident_id'   => $contact->id,
        ]);
    }

    /**
     * @test
     */
    public function create_contact_with_email_and_phone() {

        $this->withoutExceptionHandling();

        $user = (new UserGenerator())
            ->addPermission("create_contact")
            ->generate();

        $this->actingAs($user);

        $client = factory(Client::class)->create();
        $data = [
            'first_name' => 'Xavier',
            'last_name'  => 'Au',
            'client_id'  => $client->id,
            'emails'     => [
                [
                    'email' => 'xavier.au@anacreation.com',
                    'type'  => 'business',
                ],
                [
                    'email' => 'xavier.au@gmail.com',
                    'type'  => 'business',
                ],
            ],
            'phones'     => [
                [
                    'number' => '81007123',
                    'type'   => 'business',
                ],
                [
                    'number' => '66281556',
                    'type'   => 'mobile',
                ],
            ],
        ];

        $uri = route("contacts.store");

        $this->post($uri, $data);

        $contact = Contact::whereFirstName($data['first_name'])
                          ->whereLastName($data['last_name'])
                          ->whereClientId($data['client_id'])
                          ->first();


        $this->assertDatabaseHas('phones',
            [
                'number'     => $data['phones'][0]['number'],
                'type'       => $data['phones'][0]['type'],
                'owner_type' => Contact::class,
                'owner_id'   => $contact->id,
            ],
            );

        $this->assertDatabaseHas('phones', [
                'number'     => $data['phones'][1]['number'],
                'type'       => $data['phones'][1]['type'],
                'owner_type' => Contact::class,
                'owner_id'   => $contact->id,
            ]
        );
        $this->assertDatabaseHas('emails', [
            'email'      => $data['emails'][0]['email'],
            'type'       => $data['emails'][0]['type'],
            'owner_type' => Contact::class,
            'owner_id'   => $contact->id,
        ]);

        $this->assertDatabaseHas('emails', [

            'email'      => $data['emails'][1]['email'],
            'type'       => $data['emails'][1]['type'],
            'owner_type' => Contact::class,
            'owner_id'   => $contact->id,
        ]);

    }
}

