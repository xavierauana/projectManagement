<?php

namespace Tests\Feature;

use App\Invoice;
use App\Product;
use App\Project;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\UserGenerator;

class ManageProjectInvoiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function get_create_an_invoice_page() {
        $this->withoutExceptionHandling();

        $user = (new UserGenerator)
            ->addPermission('create_invoice')
            ->generate();

        $this->actingAs($user);

        $project = factory(Project::class)->create();

        $uri = route('projects.invoices.create', $project);
        $this->get($uri)
             ->assertViewIs('projects.invoices.create')
             ->assertViewHas('project');

    }

    /**
     * @test
     */
    public function get_edit_project_invoice_page() {
        $this->withoutExceptionHandling();

        $user = (new UserGenerator)
            ->addPermission('create_invoice')
            ->addPermission('edit_invoice')
            ->generate();

        $this->actingAs($user);

        $project = factory(Project::class)->create();

        $uri = route('projects.invoices.store', $project);
        $dateString = "2019/12/31";
        $data = [
            'due_date'       => Carbon::createFromFormat("Y/m/d", $dateString)
                                      ->toDateString(),
            'invoice_number' => Str::uuid()
        ];
        $this->post($uri, $data);

        $invoice = Invoice::first();

        $this->get(route('projects.invoices.edit', [$project, $invoice]), $data)
             ->assertViewIs('projects.invoices.edit')
             ->assertViewHas('project')
             ->assertViewHas('invoice');

    }

    /**
     * @test
     */
    public function create_an_invoice_for_project() {
        $this->withoutExceptionHandling();

        $user = (new UserGenerator)
            ->addPermission('create_invoice')
            ->generate();

        $this->actingAs($user);

        $project = factory(Project::class)->create();

        $uri = route('projects.invoices.store', $project);
        $dateString = "2019/12/31";
        $data = [
            'due_date'       => Carbon::createFromFormat("Y/m/d", $dateString)
                                      ->toDateString(),
            'invoice_number' => Str::uuid()
        ];
        $this->post($uri, $data)
             ->assertRedirect(route('projects.invoices.index', $project))
             ->assertSessionHas('message');

        $this->assertDatabaseHas('invoices', [
            'billable_type'  => Project::class,
            'billable_id'    => $project->id,
            'invoice_number' => $data['invoice_number'],
        ]);
    }

    /**
     * @test
     */
    public function create_an_invoice_with_invoice_item() {
        $this->withoutExceptionHandling();

        $user = (new UserGenerator)
            ->addPermission('create_invoice')
            ->generate();

        $this->actingAs($user);

        $project = factory(Project::class)->create();

        $uri = route('projects.invoices.store', $project);

        $dateString = "2019/12/31";

        $products = factory(Product::class, 2)->create()->map(function (
            Product $product
        ) {
            return [
                'product_id'   => $product->id,
                'product_type' => get_class($product),
                'unit_price'   => rand(1, 1000),
                'quantity'     => rand(1, 100),
            ];
        })->toArray();

        $data = [
            'due_date'       => Carbon::createFromFormat("Y/m/d", $dateString)
                                      ->toDateString(),
            'invoice_number' => Str::uuid(),
            'items'          => $products
        ];

        $response = $this->post($uri, $data);

        $invoice = Invoice::whereInvoiceNumber($data['invoice_number'])
                          ->first();

        foreach ($products as $product) {
            $this->assertDatabaseHas('invoice_items', [
                'invoice_id'   => $invoice->id,
                'product_type' => $product['product_type'],
                'product_id'   => $product['product_id'],
            ]);
        }
    }

    /**
     * @test
     */
    public function get_all_invoices() {

        $this->withoutExceptionHandling();

        $user = (new UserGenerator)
            ->addPermission('create_invoice')
            ->addPermission('browse_invoice')
            ->generate();

        $this->actingAs($user);

        $project = factory(Project::class)->create();

        $uri = route('projects.invoices.store', $project);
        $dateString = "2019/12/31";

        $numberOfInvoices = 4;

        for ($i = 0; $i < $numberOfInvoices; $i++) {
            $data = [
                'due_date'       => Carbon::createFromFormat("Y/m/d",
                    $dateString)->toDateString(),
                'invoice_number' => Str::uuid()
            ];
            $this->post($uri, $data);
        }

        $this->get(route('projects.invoices.index', $project))
             ->assertViewIs('projects.invoices.index')
             ->assertViewHas('invoices')
             ->assertViewHas('project');

    }
}
