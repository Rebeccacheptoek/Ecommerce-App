<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Redis::flushall();
    }

    public function test_user_can_add_product_to_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/cart', [
                'product_id' => $product->id,
                'quantity' => 2
            ]);

        $response->assertStatus(200);

        $cartContents = $this->getJson('/api/cart');
        $cartContents->assertJsonStructure(['data' => [['product', 'quantity']]]);
    }

    public function test_user_can_remove_product_from_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // First add item to cart
        $this->actingAs($user)
            ->postJson('/api/cart', [
                'product_id' => $product->id,
                'quantity' => 1
            ]);

        // Then remove it
        $response = $this->deleteJson("/api/cart/{$product->id}");
        $response->assertStatus(200);

        $cartContents = $this->getJson('/api/cart');
        $cartContents->assertJson(['data' => []]);
    }
}
