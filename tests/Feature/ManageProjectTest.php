<?php

namespace Tests\Feature;

use App\Client;
use App\Http\Requests\Project\StoreRequest;
use App\Product;
use App\Project;
use Carbon\Carbon;
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
    public function get_create_project_page() {
        $this->withoutExceptionHandling();

        $user = (new UserGenerator())
            ->addPermission('create_project')
            ->generate();
        $this->actingAs($user);


        $uri = route('projects.create');
        $response = $this->get($uri);

        $response->assertViewIs('projects.create')
                 ->assertViewHas('users')
                 ->assertSee('Title')
                 ->assertSee('Start date')
                 ->assertSee('End date')
                 ->assertSee('Notification publish at')
                 ->assertSee('Notification send to');

    }

    /**
     * @test
     */
    public function create_new_project() {
        $user = (new UserGenerator())
            ->addPermission('create_project')
            ->generate();
        $this->actingAs($user);

        $client = factory(Client::class)->create();


        $this->withoutExceptionHandling();
        $products = factory(Product::class, 3)->create();

        $data = [
            'client_id'  => $client->id,
            'title'      => 'title',
            'start_date' => "2019/1/1",
            "end_date"   => "2019/12/31",
            "items"      => [
                [
                    'product_type' => get_class($products[0]),
                    'product_id'   => $products[0]->id,
                    'quantity'     => 1,
                ],
                [
                    'product_type' => get_class($products[1]),
                    'product_id'   => $products[1]->id,
                    'quantity'     => 2,
                ],
                [
                    'product_type' => get_class($products[2]),
                    'product_id'   => $products[2]->id,
                    'quantity'     => 3,
                ],
            ]
        ];

        $uri = route('projects.store');
        $this->post($uri, $data)
             ->assertRedirect(route('projects.index'))
             ->assertSessionHas("message");

        $project = Project::where([
            'title'      => $data['title'],
            'start_date' => $data['start_date'],
            'end_date'   => $data['end_date'],
        ])->firstOrFail();

        for ($i = 0; $i < 3; $i++) {
            $this->assertDatabaseHas('product_project', [
                'product_id' => $products[$i]->id,
                'project_id' => $project->id,
                'qty'        => $i + 1
            ]);
        }
    }

    /**
     * @test
     */
    public function update_project() {
        $user = (new UserGenerator())
            ->addPermission('edit_project')
            ->generate();
        $this->actingAs($user);

        $project = factory(Project::class)->create();

        $products = factory(Product::class, 3)->create();

        $products->each(function (Product $product, $index) use ($project) {
            $project->addProduct($product, $index + 1);
        });

        $this->withoutExceptionHandling();


        $data = [
            'title'      => 'new title',
            'start_date' => "2019/2/1",
            "end_date"   => "2019/3/1",
            "items"      => [
                [
                    'product_type' => get_class($products[0]),
                    'product_id'   => $products[0]->id,
                    'quantity'     => 2,
                ],
                [
                    'product_type' => get_class($products[1]),
                    'product_id'   => $products[1]->id,
                    'quantity'     => 3,
                ]
            ]
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
        for ($i = 0; $i < 2; $i++) {
            $this->assertDatabaseHas('product_project', [
                'product_id' => $products[$i]->id,
                'project_id' => $project->id,
                'qty'        => $i + 2,
            ]);
        }

        $this->assertDatabaseMissing('product_project', [
            'product_id' => 3,
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

    /**
     * @test
     */
    public function delete_project() {

        $this->withExceptionHandling();

        Carbon::setTestNow('2019', '1', '1');

        $project = factory(Project::class)->create();
        $products = factory(Product::class, 3)->create()->each(function ($p) use
        (
            $project
        ) {
            $project->addProduct($p, 3);
        });

        $user = (new UserGenerator())
            ->addRole('super_admin')
            ->addPermission('delete_project')
            ->generate();
        $this->actingAs($user);


        $uri = route('projects.destroy', $project);

        $this->delete($uri)
             ->assertRedirect(route('projects.index'))
             ->assertSessionHas('message');

        $this->assertDatabaseHas('projects', [
            'id'         => $project->id,
            'deleted_at' => Carbon::now()
        ]);

        $products->each(function ($p) use ($project) {
            $this->assertDatabaseMissing('product_project', [
                'project_id' => $project->id,
                'product_id' => $p->id,
            ]);
        });

    }


}
