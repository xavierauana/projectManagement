<?php

namespace Tests\Feature;

use App\Http\Requests\Project\StoreRequest;
use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;
use Tests\UserGenerator;

class ManageProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function list_projects() {

        $this->withoutExceptionHandling();

        $user = (new UserGenerator())
            ->addRole('super_admin')
            ->addPermission('browse_project')
            ->generate();
        $this->actingAs($user);

        $uri = route('projects.index');

        $this->get($uri)->assertStatus(200)
             ->assertViewHas('projects');
    }

    /**
     * @test
     */
    public function create_new_project() {
        $user = (new UserGenerator())
            ->addRole('super_admin')
            ->addPermission('create_project')
            ->generate();
        $this->actingAs($user);

        $this->withoutExceptionHandling();

        $data = [
            'title'      => 'title',
            'start_date' => "2019/1/1",
            "end_date"   => "2019/12/31"
        ];

        $uri = route('projects.store');
        $this->post($uri, $data)
             ->assertRedirect(route('projects.index'))
             ->assertSessionHas("message");
        $this->assertDatabaseHas('projects', [
            'title'      => $data['title'],
            'start_date' => $data['start_date'],
            'end_date'   => $data['end_date'],
        ]);
    }

    /**
     * @test
     */
    public function update_project() {
        $user = (new UserGenerator())
            ->addRole('super_admin')
            ->addPermission('update_project')
            ->generate();
        $this->actingAs($user);

        $project = factory(Project::class)->create();

        $this->withoutExceptionHandling();

        $data = [
            'title'      => 'new title',
            'start_date' => "2019/2/1",
            "end_date"   => "2019/3/1"
        ];

        $uri = route('projects.update', $project);

        $this->put($uri, $data)
             ->assertRedirect(route('projects.index'))
             ->assertSessionHas("message");
        $this->assertDatabaseHas('projects', [
            'title'      => $data['title'],
            'start_date' => $data['start_date'],
            'end_date'   => $data['end_date'],
        ]);
    }

    /**
     * @test
     */
    public function store_form_request_rules() {

        $data = [
            'title'      => 'title',
            'start_date' => '2019/1/31',
            'end_date'   => '2019/1/1',
        ];
        $request = new StoreRequest();

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());

    }


}
