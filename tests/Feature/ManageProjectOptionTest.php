<?php

namespace Tests\Feature;

use App\ProjectOption;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\UserGenerator;

class ManageProjectOptionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_new_project_option() {
        $user = (new UserGenerator())
            ->addRole('super_admin')
            ->addPermission('create_project_option')
            ->generate();
        $this->actingAs($user);

        $this->withoutExceptionHandling();

        $data = [
            'title' => 'title',
        ];

        $uri = route('project_options.store');
        $this->post($uri, $data)
             ->assertRedirect(route('project_options.index'))
             ->assertSessionHas("message");
        $this->assertDatabaseHas('project_options', [
            'title' => $data['title']
        ]);
    }

    /**
     * @test
     */
    public function update_project_option() {
        $user = (new UserGenerator())
            ->addRole('super_admin')
            ->addPermission('update_project_option')
            ->generate();
        $this->actingAs($user);

        $project = factory(ProjectOption::class)->create();

        $this->withoutExceptionHandling();

        $data = [
            'title' => 'new title',
        ];

        $uri = route('project_options.update', $project);

        $this->put($uri, $data)
             ->assertRedirect(route('project_options.index'))
             ->assertSessionHas("message");
        $this->assertDatabaseHas('project_options', [
            'title' => $data['title']
        ]);
    }

}
