<?php

namespace Tests\Feature;

use App\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\UserGenerator;

class ManageClientContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function get_client_contacts_page() {
        $this->withoutExceptionHandling();

        $user = (new UserGenerator())
            ->addPermission("browse_contact")
            ->generate();
        $this->actingAs($user);

        $client = factory(Client::class)->create();

        $uri = route('clients.contacts.index', $client);
        $this->get($uri)
             ->assertViewIs("clients.contacts.index")
             ->assertViewHas('client')
             ->assertViewHas('contacts');

    }

    /**
     * @test
     */
    public function get_create_new_contact_page() {
        $this->withoutExceptionHandling();

        $user = (new UserGenerator())
            ->addPermission("create_contact")
            ->generate();
        $this->actingAs($user);

        $client = factory(Client::class)->create();

        $uri = route('clients.contacts.create', $client);
        $this->get($uri)
             ->assertViewIs("clients.contacts.create")
             ->assertViewHas('client');

    }

    /**
     * @test
     */
    public function post_to_create_new_contact() {

        $this->withoutExceptionHandling();

        $user = (new UserGenerator())
            ->addPermission("create_contact")
            ->generate();
        $this->actingAs($user);

        $client = factory(Client::class)->create();

        $uri = route('clients.contacts.store', $client);

        $data = [
            'first_name' => "Xavier",
            'last_name'  => "Au"
        ];
        $this->post($uri, $data)
             ->assertRedirect(route('clients.contacts.index', $client))
             ->assertSessionHas('message');

        $this->assertDatabaseHas('contacts', [
            'client_id'  => $client->id,
            'first_name' => "Xavier",
            'last_name'  => "Au"
        ]);
    }


    /**
     * @test
     */
    public function get_edit_contact_page() {

        $this->withoutExceptionHandling();

        $user = (new UserGenerator())
            ->addPermission("create_contact")
            ->addPermission("edit_contact")
            ->generate();
        $this->actingAs($user);

        $client = factory(Client::class)->create();

        $uri = route('clients.contacts.store', $client);

        $data = [
            'first_name' => "Xavier",
            'last_name'  => "Au"
        ];
        $this->post($uri, $data);


        $contact = $client->contacts()->where($data)->first();

        $uri = route('clients.contacts.edit', [$client, $contact]);

        $this->get($uri)
             ->assertViewIs('clients.contacts.edit', [$client, $contact])
             ->assertViewHas("client")
             ->assertViewHas("contact");

    }

    /**
     * @test
     */
    public function put_edit_contact() {

        $this->withoutExceptionHandling();

        $user = (new UserGenerator())
            ->addPermission("create_contact")
            ->addPermission("edit_contact")
            ->generate();
        $this->actingAs($user);

        $client = factory(Client::class)->create();

        $uri = route('clients.contacts.store', $client);

        $data = [
            'first_name' => "Xavier",
            'last_name'  => "Au"
        ];
        $this->post($uri, $data);

        $newdata = [
            'first_name' => "Xavier",
            'last_name'  => "Au"
        ];

        $contact = $client->contacts()->where($data)->first();

        $uri = route('clients.contacts.update', [$client, $contact]);

        $this->put($uri, $newdata)
             ->assertRedirect(route('clients.contacts.index', $client))
             ->assertSessionHas("message");


        $this->assertDatabaseHas('contacts', [
            'client_id'  => $client->id,
            'first_name' => $newdata['first_name'],
            'last_name'  => $newdata['last_name']
        ]);
    }

    /**
     * @test
     */
    public function delete_contact() {
        $this->withoutExceptionHandling();

        $user = (new UserGenerator())
            ->addPermission("create_contact")
            ->addPermission("delete_contact")
            ->generate();
        $this->actingAs($user);

        $client = factory(Client::class)->create();

        $uri = route('clients.contacts.store', $client);

        $data = [
            'first_name' => "Xavier",
            'last_name'  => "Au"
        ];
        $this->post($uri, $data);

        $contact = $client->contacts()->where($data)->first();

        $uri = route('clients.contacts.destroy', [$client, $contact]);

        $this->delete($uri)
             ->assertRedirect(route('clients.contacts.index', $client))
             ->assertSessionHas('message');

        $this->assertDatabaseMissing('contacts', [
            'client_id'  => $client->id,
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
        ]);

    }
}
