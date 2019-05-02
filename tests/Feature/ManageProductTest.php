<?php

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\UserGenerator;

class ManageProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function get_product_index_page() {

        $this->withoutExceptionHandling();
        $user = (new UserGenerator())
            ->addPermission('browse_product')
            ->generate();
        $this->actingAs($user);


        $uri = route('products.index');

        $this->get($uri)
             ->assertViewIs('products.index')
             ->assertViewHas('products');

    }

    /**
     * @test
     */
    public function get_edit_product_page() {
        $this->withoutExceptionHandling();
        $user = (new UserGenerator())
            ->addPermission('edit_product')
            ->generate();
        $this->actingAs($user);
        $product = factory(Product::class)->create();


        $uri = route('products.edit', $product);

        $this->get($uri)
             ->assertViewIs('products.edit')
             ->assertViewHas('product');

    }

    /**
     * @test
     */
    public function put_edit_product() {
        $this->withoutExceptionHandling();
        $user = (new UserGenerator())
            ->addPermission('edit_product')
            ->generate();
        $this->actingAs($user);
        $product = factory(Product::class)->create();

        $data = [
            'name'      => 'update product name',
            'price'     => 100,
            'is_active' => false,
        ];

        $uri = route('products.update', $product);

        $this->put($uri, $data)
             ->assertRedirect(route("products.index"))
             ->assertSessionHas('message');

        $this->assertDatabaseHas('products', [
            'id'        => $product->id,
            'name'      => $data['name'],
            'price'     => $data['price'] * 100,
            'is_active' => $data['is_active'],
        ]);

    }

    /**
     * @test
     */
    public function get_create_product_page() {
        $this->withoutExceptionHandling();
        $user = (new UserGenerator())
            ->addPermission('create_product')
            ->generate();
        $this->actingAs($user);


        $uri = route('products.create');

        $this->get($uri)
             ->assertViewIs('products.create');

    }

    /**
     * @test
     */
    public function post_create_product() {

        $this->withoutExceptionHandling();
        $user = (new UserGenerator())
            ->addPermission('create_product')
            ->generate();
        $this->actingAs($user);


        $uri = route('products.store');

        $data = [
            'name'      => "product name",
            'price'     => 300,
            'is_active' => true
        ];

        $this->post($uri, $data)
             ->assertRedirect(route('products.index'))
             ->assertSessionHas('message');

        $this->assertDatabaseHas('products', [
            'name'      => $data['name'],
            'price'     => $data['price'] * 100,
            'is_active' => $data['is_active'],
        ]);

    }

    /**
     * @test
     */
    public function delete_product() {

        $this->withoutExceptionHandling();
        $user = (new UserGenerator())
            ->addPermission('delete_product')
            ->generate();
        $this->actingAs($user);
        $product = factory(Product::class)->create();


        $uri = route('products.destroy', $product);

        $this->delete($uri);

        $this->assertDatabaseMissing('products', [
            'id'   => $product->id,
            'name' => $product->name,
        ]);
    }
}
