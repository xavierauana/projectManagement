<?php

namespace Tests\Feature;

use App\Client;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\UserGenerator;

class ManagementClientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function browse_companies() {
        $this->withExceptionHandling();

        $user = (new UserGenerator)
            ->addPermission('browse_client')
            ->generate();

        $this->actingAs($user);

        $this->get(route('clients.index'))
             ->assertViewIs('clients.index')
             ->assertViewHas('clients');
    }

    /**
     * @test
     */
    public function create_client() {
        $this->withExceptionHandling();

        $user = (new UserGenerator)
            ->addPermission('create_client')
            ->generate();

        $this->actingAs($user);

        $this->get(route('clients.create'))
             ->assertViewIs('clients.create');

    }

    /**
     * @test
     */
    public function edit_client() {
        $this->withExceptionHandling();

        $user = (new UserGenerator)
            ->addPermission('edit_client')
            ->generate();

        $this->actingAs($user);

        $this->get(route('clients.edit', factory(Client::class)->create()))
             ->assertViewIs('clients.edit')
             ->assertViewHas('client');

    }

    /**
     * @test
     */
    public function store_a_client() {
        $this->withoutExceptionHandling();

        $user = (new UserGenerator)
            ->addPermission("create_client")
            ->generate();
        $this->actingAs($user);

        $data = [
            'name' => 'Client 1'
        ];
        $uri = route('clients.store');

        $this->post($uri, $data)
             ->assertRedirect(route('clients.index'))
             ->assertSessionHas('message');

        $this->assertDatabaseHas('clients', [
            'name' => $data['name']
        ]);
    }

    /**
     * @test
     */
    public function update_client() {
        $this->withoutExceptionHandling();

        $user = (new UserGenerator)
            ->addPermission("edit_client")
            ->generate();
        $this->actingAs($user);

        $data = [
            'name' => 'new Client'
        ];
        $uri = route('clients.update', factory(Client::class)->create());

        $this->put($uri, $data)
             ->assertRedirect(route('clients.index'))
             ->assertSessionHas('message');

        $this->assertDatabaseHas('clients', [
            'name' => $data['name']
        ]);
    }

    /**
     * @test
     */
    public function destroy_client() {

        Carbon::setTestNow('2019', '1', '1');

        $this->withoutExceptionHandling();

        $user = (new UserGenerator)
            ->addPermission("delete_client")
            ->generate();
        $this->actingAs($user);

        $client = factory(Client::class)->create();
        $uri = route('clients.destroy', $client);

        $this->delete($uri)
             ->assertRedirect(route('clients.index'))
             ->assertSessionHas('message');

        $this->assertDatabaseHas('clients', [
            'id'         => $client->id,
            'deleted_at' => Carbon::now(),
        ]);

    }
}
