<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_available_products()
    {
        Product::factory()->count(5)->create(['stock' => 10]);
        Product::factory()->count(2)->create(['stock' => 0]);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'price',
                        'stock',
                        'image_url',
                        'sku',
                        'available'
                    ]
                ]
            ]);
    }

    public function test_can_get_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => (string) $product->price,
                    'stock' => $product->stock
                ]
            ]);
    }

    public function test_can_search_products()
    {
        $product = Product::factory()->create([
            'name' => 'Special Product'
        ]);

        $response = $this->getJson('/api/products/search?term=Special');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJson([
                'data' => [
                    [
                        'id' => $product->id,
                        'name' => $product->name
                    ]
                ]
            ]);
    }
}
