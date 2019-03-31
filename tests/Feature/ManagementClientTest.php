<?php

namespace Tests\Feature;

use App\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\UserGenerator;

class ManagementClientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_a_client() {
        $this->withoutExceptionHandling();

        $user = (new UserGenerator)
            ->addPermission("create_client")
            ->addRole('admin')
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
            ->addPermission("update_client")
            ->addRole('admin')
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
}
