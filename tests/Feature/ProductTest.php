<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    private $product;

    public function setUp(): void
    {
        parent::setUp();
        // $user = $this->authUser();
        $this->product = Product::factory()->create();
    }

    public function test_fetch_all_product(): void
    {
        $response = $this->getJson(route('product.index'));
        $this->assertEquals(1, count($response->json()));
    }

    public function test_fetch_single_product(): void
    {
        $response = $this->getJson(route('product.show',$this->product->id))->assertOk()->json();
        $this->assertEquals($response['name'], $this->product->name);
    }
    
    public function test_stote_new_product(): void
    {
        $product = Product::factory()->make();
        $response = $this->postJson(route('product.store',['name' => $product->name]))
                    ->assertCreated()->json();
        $this->assertEquals($product->name, $response['name']);
        $this->assertDatabaseHas('products', ['name' => $product->name]);
    }

    public function test_while_storing_product_name_field_is_required()
    {
        $this->withExceptionHandling();

        $this->postJson(route('product.store'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    public function test_delete_product()
    {
        $this->deleteJson(route('product.destroy', $this->product->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('products', ['name' => $this->product->name]);
    }

    public function test_update_product()
    {
        $this->patchJson(route('product.update', $this->product->id), ['name' => 'updated name'])
            ->assertOk();

        $this->assertDatabaseHas('products', ['id' => $this->product->id, 'name' => 'updated name']);
    }

    public function test_while_updating_product_name_field_is_required()
    {
        $this->withExceptionHandling();

        $this->patchJson(route('product.update', $this->product->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

}
