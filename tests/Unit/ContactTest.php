<?php

namespace Tests\Unit;

use App\Address;
use App\Client;
use App\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function belongs_to_a_client() {
        $this->assertInstanceOf(Client::class,
            factory(Contact::class)->create()->client);
    }

    /**
     * @test
     */
    public function contact_has_no_client() {
        $contact = Contact::create([
            'first_name' => 'Xavier',
            'last_name'  => 'Au',
        ]);

        $this->assertNull($contact->client);

    }

    /**
     * @test
     */
    public function has_many_addresses() {

        $contact = factory(Contact::class)->create();

        $this->assertInstanceOf(Collection::class, $contact->addresses);

    }

    /**
     * @test
     */
    public function add_an_address() {
        $address = factory(Address::class)->make();

        $contact = factory(Contact::class)->create();

        $contact->addAddress($address);

        $this->assertDatabaseHas('addresses', [
            'resident_type' => get_class($contact),
            'resident_id'   => $contact->id,
            'address_1'     => $address['address_1'],
            'address_2'     => $address['address_2'],
            'address_3'     => $address['address_3'],
        ]);

    }
}
