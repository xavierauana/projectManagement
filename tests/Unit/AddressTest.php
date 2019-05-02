<?php

namespace Tests\Unit;

use App\Address;
use App\Contact;
use App\Enums\AddressType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function has_enums_type() {
        $resident = factory(Contact::class)->create();
        $address = factory(Address::class)->create([
            'resident_type' => Contact::class,
            'resident_id'   => $resident->id,
        ]);

        switch ($address->type) {
            case AddressType::Business():
                $this->assertTrue(true);
                break;
            default:
                $this->assertTrue(false);
        }
    }
}
