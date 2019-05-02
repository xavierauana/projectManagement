<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Tests\UserGenerator;

class ManageUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function unauthentication() {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $uris = [
            'get' => [
                route('users.index'),
                route('users.edit', $user)
            ],

        ];

        foreach ($uris as $action => $routes) {
            foreach ($routes as $route) {
                $this->getException($action, $route,
                    new AuthenticationException);
            }
        }
    }


    /**
     * @test
     */
    public function index_page() {
        $this->withoutExceptionHandling();

        $user = (new UserGenerator)
            ->addPermission('browse_users')
            ->generate();
        $this->actingAs($user);

        $uri = route('users.index');
        $response = $this->get($uri);

        $response->assertViewIs('users.index')
                 ->assertViewHas('users');
        $users = $response->viewData('users');

        $this->assertInstanceOf(LengthAwarePaginator::class, $users);
    }


    /**
     * @test
     */
    public function get_edit_page() {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $uri = route('users.edit', $user);

        //        $this->expectException(AuthenticationException::class);
        //
        //        $this->get($uri);

        //                $admin = (new UserGenerator)
        //                    ->generate();
        //                $this->actingAs($admin);
        //
        //                $this->expectException(AuthorizationException::class);
        //                $this->get($uri);


        $admin = (new UserGenerator)
            ->addPermission('edit_user')
            ->generate();
        $this->actingAs($admin);

        $response = $this->get($uri);

        $response->assertViewIs('users.edit')
                 ->assertViewHasAll(['user', 'roles']);
        $vu = $response->viewData('user');

        $this->assertEquals($user->id, $vu->id);
    }

    /**
     * @test
     */
    public function update_user() {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $uri = route('users.update', $user);

        //        $this->expectException(AuthenticationException::class);
        //
        //        $this->put($uri);

        //                        $admin = (new UserGenerator)
        //                            ->generate();
        //                        $this->actingAs($admin);
        //
        //                        $this->expectException(AuthorizationException::class);
        //                        $this->put($uri);


        $admin = (new UserGenerator)
            ->addPermission('edit_user')
            ->generate();
        $this->actingAs($admin);

        $role1 = Role::create([
            'name' => "role1"
        ]);
        $role2 = Role::create([
            'name' => "role2"
        ]);

        $data = [
            'first_name' => 'new first name',
            'last_name'  => 'new last name',
            'email'      => 'newemail@abc.com',
            'roles'      => [
                'role1',
                'role2',
            ]
        ];
        $response = $this->put($uri, $data);

        $response->assertRedirect('users.index')
                 ->assertSessionHas('message');

        $this->assertDatabaseHas('users', [
            'id'         => $user->id,
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
        ]);

        $this->assertDatabaseHas('model_has_roles', [
            'model_type' => get_class($user),
            'model_id'   => $user->id,
            'role_id'    => $role1->id
        ]);
        $this->assertDatabaseHas('model_has_roles', [
            'model_type' => get_class($user),
            'model_id'   => $user->id,
            'role_id'    => $role2->id
        ]);

    }

    /**
     * @param $action
     * @param $route
     */
    private function getException($action, $route, \Exception $e): void {
        $this->expectException(get_class($e));
        $this->{$action}($route);
    }
}
